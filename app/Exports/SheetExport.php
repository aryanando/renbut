<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetExport implements WithMultipleSheets
{
    protected $arr;

    public function __construct(string $periode)
    {
        $this->periode = date('Y-m-t', strtotime($periode));
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach (['alkes', 'atk', 'bhp', 'cetak', 'obat', 'rumah_tangga', 'sarpras'] as $key => $value) {
            if( $value =='bhp' ){
                $arr = DB::select("call sp_to_excel_2('". $this->periode ."', '". $value ."')");
                $header = [];
                foreach (array_keys((array)($arr[0] ?? [])) as $k_str) {
                $header[] = strtoupper($k_str);
                }
            }
            else {
                $arr = DB::select("call sp_to_excel_2('". $this->periode ."', '". $value ."')");
                $header = [];
                foreach (array_keys((array)($arr[0] ?? [])) as $k_str) {
                $header[] = strtoupper($k_str);
                }
                
            }
            array_unshift($arr, $header);
            array_unshift($arr, ['BULAN ' . strtoupper(date('F Y', strtotime($this->periode . ' + 1 day')))]);
            array_unshift($arr, ['DAFTAR KEBUTUHAN '. strtoupper($value) ]);
            $sheets[] = new ArrayExport($arr, $value);
        }

        return $sheets;
    }
}
