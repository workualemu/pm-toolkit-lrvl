<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;

class ReportController implements FromCollection, WithHeadings, WithProperties
{
    use Exportable;

    public $data;
    public $title;
    public $meta;
    public $columns;
    public $properties;

    public function __construct($data, $title, $meta, $columns, $properties=[])
    {
        $this->data = $data;
        $this->title = $title;
        $this->meta = $meta;
        $this->columns = $columns;
        $this->properties = $properties;

    }

    public function collection()
    {
        return $this->data;
        
    }

    public function headings(): array
    {
        return $this->columns;
    }

    public function properties(): array
    {
        return $this->properties;
    }

}