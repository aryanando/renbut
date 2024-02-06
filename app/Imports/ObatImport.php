<?php

namespace App\Imports;

use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Uraian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Auth;

class ObatImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $periode = date('Y-m-t',strtotime($row[0]));
        $user_id = Auth::user()->id;
        $unit_id = Auth::user()->unit;
        $uraian = strtoupper($row[1] ?? '');
        $satuan = ucfirst(strtolower($row[2] ?? ''));
        $harga = $row[4] ?? 0;
        $jumlah = $row[3] ?? 0;

        Obat::updateOrCreate(
            [
                'periode' => $periode,
                'unit_id' => $unit_id,
                'uraian' => $uraian,
            ],
            [
                "user_id" => $user_id,
                "satuan" => $satuan,
                "jumlah" => $jumlah,
                "harga" => $harga,
                "total" => $jumlah * $harga,
            ],
        );
        Uraian::updateOrCreate(
            [
                'keterangan' => $uraian,
                'satuan' => $satuan,
                'bagian' => 'obat',
            ],
            [
                'harga' => $harga,
            ],
        );
        Satuan::updateOrCreate(
            [
                'keterangan' => $satuan,
            ],
            [],
        );

        return new Obat([
            "user_id" => $user_id,
            "periode" => $periode,
            "uraian" => $uraian,
            "satuan" => $satuan,
            "unit_id" => $unit_id,
            "jumlah" => $jumlah,
            "harga" => $harga,
            "total" => $jumlah * $harga,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
