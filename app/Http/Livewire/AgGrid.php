<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AgGrid extends Component
{
    public $columns = []; // Holds the dynamic column definitions
    public $rows = [];    // Holds the dynamic row data
    public string $htmlId;
    public array $rawData = [];
    public array $data = [];
    public array $layout = [];
    public array $options = [];

    // protected $listeners = ['changeOccurred' => 'reactToChanges'];

    public const DEFAULT_OPTIONS = [
        'columnTypes' => [
            'rangeColumn' => [
                'width' => 150,
                'filter'=> "agNumberColumnFilter"
            ],
            'textColumn' => [
                'width' => 200,
                'filter'=> "agTextColumnFilter"
            ],
            'numericColumn' => [
                'width' => 150,
                'filter'=> "agNumberColumnFilter"
            ]
        ],
        'columnDefs' => ['filter'=>true, 'sortable'=>true,'floatingFilter'=>true,],
        'rowData' => [],
        'autoSizeStrategy' => [
            'type' => 'fitGridWidth'
        ],
    ];

    public function mount($data)
    {
        $this->data = $data;
        $this->htmlId = 'tbl-' . str()->random(5);

        if (! empty($this->data)) {

            $this->preparePayload($this->data);
        }
    }

    public function refreshGrid()
    {
        $this->emit('refreshGrid', $this->columns, $this->rows);
    }


    /**
     * Generates column definitions for a table based on the provided data.
     *
     * This function processes the data to create nested and flat column definitions.
     * It handles columns with nested headers (indicated by a '|' in the header name)
     * and applies specific configurations for numeric and range columns.
     *
     * @param \Illuminate\Support\Collection $data The data collection to generate column definitions from.
     * @return array An array of column definitions for the table.
     */
    private function makeColumnDefs($data): array
    {
        if ($data->isNotEmpty()) {
            $flat = collect(array_keys((array)$data->first()));

            $notNested = $flat
                ->map(function ($column) {
                    $colDef = [
                        'headerName' => str($column)->replace('_', ' ')->ucfirst()->toString(),
                        'field' => $column,
                        'filter' => true,
                        'floatingFilter'=>true,
                        'sortable' => true,
                        "unSortIcon" => true
                    ];
                    if (str($column)->endsWith("num")){
                        $colDef['hozAlign'] = 'right';
                        $colDef['headerHozAlign'] = 'right';
                        //$colDef['sorter'] = 'number';
                        //$colDef['formatter'] = 'money';
                        $colDef['type'] = 'numericColumn';
                        unset($colDef['filter']);
                    }
                    if (str($column)->contains('age_group')){
                        //$colDef['sorter'] = 'number';
                        $colDef['type'] = 'rangeColumn';
                    }
                    if (str($column)->contains('date')){
                        //$colDef['sorter'] = 'number';
                        $colDef['type'] = 'dateColumn';
                    }
                    return $colDef;
                });

            return $notNested
                ->map(fn ($header) => (object)$header)
                ->values()
                ->all();
        }
        return [];
    }

    /**
     * Prepares the payload for the table visualization.
     *
     * This method updates the options array by merging it with the default options
     * and sets the row data and column definitions based on the provided raw data.
     *
     * @param array $rawData The raw data to be used for the table visualization. Defaults to an empty array.
     *
     * @return void
     */
    public function preparePayload(array $rawData = []): void
    {
        $this->options = array_replace_recursive($this::DEFAULT_OPTIONS, $this->options);
        $this->options['rowData'] = $rawData;
        $this->options['columnDefs'] = $this->makeColumnDefs(collect($rawData));
        
    }

    
    // public function reactToChanges($rawData): void
    // {
    //     $this->preparePayload($rawData);
    //     $this->emit("updateTable.$this->htmlId", $this->options);
    // }

    public function render()
    {
        return view('livewire.ag-grid');
    }
}