<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Livewire\Attributes\On;

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
    public $selectedReportTitle;

    public $showReportModal = false;

    #[On('showReportViewer')]
    public function showReportViewer($report_id, $results)
    {
        $this->selectedReportID = $report_id;
        $report = Report::find($report_id);
        $this->selectedReportTitle = $report?->title;
        $this->results = $results;
        $this->showReportUse = false;
        // $this->queryBuilder = $queryBuilder;
        $this->dispatch('$refresh');
        $this->dispatch(
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

        $projectTable = $this->findTableWithProjectId($sql);
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

        if(!empty($selectedReport->order_clause)){
            $sql .= " ORDER BY " . $selectedReport->order_clause;
        }

        $this->results = DB::select($sql);
        $this->selectedReportID = $selectedReport->id;

        if(!empty($this->results)){
            $this->showReportViewer($selectedReport->id, $this->results);
        }
        
    }

    public function mount($project)
    {
        $user =  Auth::user();
        $this->project = Project::find($user->project_id);
    }

    public function renderUseParam($report_id)
    {
        $this->selectedReportId = $report_id;
        $this->dispatch('renderUseParam', $report_id);
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
    
        if ($selectClause && !$this->isSafeCondition($selectClause)) {
            throw new InvalidArgumentException("Invalid SELECT condition: $selectClause");
        }
        if ($fromClause && !$this->isSafeCondition($fromClause)) {
            throw new InvalidArgumentException("Invalid FROM condition: $fromClause");
        }
        
        if ($groupByClause && !$this->isSafeCondition($groupByClause)) {
            throw new InvalidArgumentException("Invalid GROUP condition: $groupByClause");
        }

        if ($orderByClause && !isSafeCondition($orderByClause)) {
            throw new InvalidArgumentException("Invalid ORDER condition: $orderByClause");
        }

        if ($whereClause && !$this->isSafeCondition($whereClause)) {
            throw new InvalidArgumentException("Invalid WHERE condition: $whereClause");
        }
        if ($havingClause && !$this->isSafeCondition($havingClause)) {
            throw new InvalidArgumentException("Invalid HAVING condition: $havingClause");
        }
        return true;
    }

    function isSafeCondition(string $clause): bool
    {
        $rawForbidden = [
            ';',               
            '--',              
            '#',               
            '/*', '*/',        
            'exec',
            'execute',
            'update',
            'delete',
            'insert',
            'drop',
            'truncate',
            'alter',
            'create',
            'grant',
            'revoke',
            'use',
            'shutdown',
            'merge',
            'call',
            'load_file',
            'outfile'
        ];

        $escaped = array_map(function($word) {
            return ctype_alpha($word) ? '\b' . preg_quote($word, '/') . '\b' : preg_quote($word, '/');
        }, $rawForbidden);

        $pattern = '/(' . implode('|', $escaped) . ')/i';

        return !preg_match($pattern, $clause);
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
                $ret = null;
                if(strtoupper($table) == 'USERS'){
                    continue;
                }
                if(strtoupper($table) == 'TASKS'){
                    return $table;
                }

                if ($this->hasColumn($table, 'project_id')) {
                    $ret = $table; 
                }
            }
            return $ret;
        }

        return null; 
    }
}
