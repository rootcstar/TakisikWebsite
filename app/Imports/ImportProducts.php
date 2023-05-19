<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Unit;
use App\Models\MainUnit;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportProducts implements ToModel, WithStartRow, WithCalculatedFormulas, SkipsEmptyRows
{

    public function startRow():int{
        return 2;
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Product([
            'barcode'     => $row[0],
            'product_code'    => $row[1],
            'product_name' => $row[2],
            'unit_qty'    => $row[4],
            'unit_id'    => Unit::where('unit_name',strtoupper($row[5]))->pluck('unit_id')->first(),
            'main_unit_qty'    => $row[6],
            'main_unit_id'    => MainUnit::where('main_unit_name',strtoupper($row[7]))->pluck('main_unit_id')->first(),
            'single_price'    => $row[8],
            'wholesale_price'    => $row[9],
            'retail_price'    => $row[10],
            'kdv'    => $row[11],
        ]);
    }
}
