<?php

namespace App\Imports;

use App\Models\Building;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class BuildingsImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Building([
            'name'          => $row[0],
            'address'       => $row[1],
            'type_building' => $row[2],
            'rental_form'   => $row[3],
            'city'          => $row[4],
            'district'      => $row[5],
            'commune'       => $row[6],
            'e_money_1kwh'  => $row[7],
            'w_money_1block'=> $row[8],
            'date_record_ew'=> $row[9],
            'date_charge'   => $row[10],
            'utilities'     => $row[11],
            'rules'         => $row[12],
            'images'        => $row[13],
            'detail'        => $row[14],
            'floor'         => $row[15],
        ]);
    }
}
