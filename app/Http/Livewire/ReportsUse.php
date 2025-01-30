<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ReportsUse extends Component
{
    public $reports = [];
    public $project;
    public $showReportUse = true;
    public $results;
    public $queryBuilder;

    public $selectedReportID;
    public $selectedParams;

    public $selectedReportId;

    public $showReportModal = false;

    protected $listeners = ['showReportViewer' => 'showReportViewer',
                            'refreshReportUsePage' => '$refresh'];

    public function showReportViewer($report_id, $results)
    {
        $this->selectedReportID = $report_id;
        $this->results = $results;
        $this->showReportUse = false;
        // $this->queryBuilder = $queryBuilder;
        $this->emit('refreshReportUsePage');
        $this->emit(
            "changeOccurred",
            rawData: $this->results
        );


    }

    public function generateReport($report_id)
    {
        $selectedReport = Report::find($report_id);
        if(!$selectedReport){
            return "Invalid report";
        }

        $user =  Auth::user();

        $this->validateInput(
            $selectedReport->select_clause,
            $selectedReport->from_clause,
            $selectedReport->where_clause,
            $selectedReport->groupby_clause,
            $selectedReport->having_clause);
        
        $sql = "SELECT ";
        $selectStmt = empty($selectedReport->select_clause)? '*' : $selectedReport->select_clause;
        $sql .= $selectStmt;

        if(empty($selectedReport->from_clause)){
            return "Invalid FROM clause";
        }
        $sql .= " FROM " . $selectedReport->from_clause;

        $projectTable = $this->findTableWithProjectId($selectedReport->from_clause);
        if($projectTable != null){
            $sql .= " WHERE " . $projectTable . ".project_id = " . $user->project_id;
            if(!empty($selectedReport->where_clause)){
                $sql .= " AND " . $selectedReport->where_clause;
            }
        } else {
            if(!empty($selectedReport->where_clause)){
                $sql .= " WHERE " . $selectedReport->where_clause;
            }
        }
        
        if(!empty($selectedReport->groupby_clause)){
            $sql .= " GROUP BY " . $selectedReport->groupby_clause;
        }

        if(!empty($selectedReport->having_clause)){
            $sql .= " HAVING " . $selectedReport->having_clause;
        }

        $this->results = DB::select($sql);
        $this->selectedReportID = $selectedReport->id;

        $this->showReportViewer($selectedReport->id, $this->results);
    }

    public function mount($project)
    {
        $user =  Auth::user();
        $this->project = Project::find($user->project_id);
    }

    public function renderUseParam($report_id)
    {
        $this->selectedReportId = $report_id;
        $this->emit('renderUseParam', $report_id);
    }

    public function render()
    {
        $user = \Auth::user();
        $this->reports = Report::where('published', '=', 1)
            ->where('project_id', $user->project_id)->get();
        return view('livewire.reports-use');
    }

    // -----------------------------Private methods------------------
    private function validateInput($selectClause, $fromClause, $whereClause, 
        $groupByClause, $havingClause, $orderByClause='') 
    {
        $forbiddenKeywords = ['DELETE', 'UPDATE', 'DROP', 'ALTER', 'INSERT', 'EXEC', '--', ';'];
    
        foreach ([$selectClause, $fromClause, $whereClause, 
            $groupByClause, $havingClause, $orderByClause] as $input) {
            foreach ($forbiddenKeywords as $keyword) {
                if (stripos($input, $keyword) !== false) {
                    throw new InvalidArgumentException("Forbidden keyword detected: $keyword");
                }
            }
        }
    
        $conditionRegex = '/^[a-zA-Z_][a-zA-Z0-9_\.]*\s*(?:=|!=|<>|>=|<=|>|<|LIKE|IS(?:\s+NOT)?)\s*(\'[^\']*\'|\"[^\"]*\"|\d+|\w+|NULL)$/i';
        if ($whereClause && !preg_match($conditionRegex, $whereClause)) {
            throw new InvalidArgumentException("Invalid WHERE condition: $whereClause");
        }
        if ($havingClause && !preg_match($conditionRegex, $havingClause)) {
            throw new InvalidArgumentException("Invalid HAVING condition: $havingClause");
        }
        return true;
    }

    function hasColumn($tableName, $columnName)
    {
        $result = DB::select("
            SELECT column_name
            FROM information_schema.columns
            WHERE table_name = :table_name 
            AND column_name = :column_name
        ", [
            'table_name' => $tableName,
            'column_name' => $columnName,
        ]);

        return !empty($result);
    }

    function getTablesFromFromClause($fromClause)
    {
        $pattern = '/(?:FROM|JOIN)\s+([a-zA-Z0-9_\.]+)/i';
        preg_match_all($pattern, $fromClause, $matches);

        return array_unique($matches[1]); // Remove duplicates if any
    }

    function findTableWithProjectId($fromClause)
    {
        $tables = $this->getTablesFromFromClause($fromClause);

        if (!empty($tables)) {
            foreach ($tables as $table) {
                if ($this->hasColumn($table, 'project_id')) {
                    return $table; 
                }
            }
        }

        return null; 
    }
}
