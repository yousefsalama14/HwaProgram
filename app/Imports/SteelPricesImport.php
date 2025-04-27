<?php

namespace App\Imports;

use App\Models\materials;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SteelPricesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new materials([
            'name' => $row['name'],
            'size' => $row['size'],
            'wholesale_price' => $row['wholesale_price'],
            'retail_price' => $row['retail_price'],
        ]);
    }
}
