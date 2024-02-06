<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ArrayExport implements FromArray, WithTitle
{
    protected $arr;
    protected $table_name;

    public function __construct(array $arr, string $table = 'Sheet 1')
    {
        $this->invoices = $arr;
        $this->table_name = $table;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->table_name;
    }
}
