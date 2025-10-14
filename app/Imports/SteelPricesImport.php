<?php

namespace App\Imports;

use App\Models\materials;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SteelPricesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        // Expect sheet names: 'normal' and 'standard' (case-insensitive). Fallback to index keys.
        return [
            0 => new SteelPricesSingleSheetImport('normal'),
            1 => new SteelPricesSingleSheetImport('standard'),
            'normal' => new SteelPricesSingleSheetImport('normal'),
            'standard' => new SteelPricesSingleSheetImport('standard'),
            'Normal' => new SteelPricesSingleSheetImport('normal'),
            'Standard' => new SteelPricesSingleSheetImport('standard'),
        ];
    }
}

class SteelPricesSingleSheetImport implements ToModel, WithHeadingRow
{
    private string $category;

    public function __construct(string $category)
    {
        $this->category = $category; // 'normal' | 'standard'
    }

    public function model(array $row)
    {
        if (!isset($row['name']) || !isset($row['size'])) {
            return null;
        }

        return new materials([
            'name' => $row['name'],
            'size' => $row['size'],
            'category' => $this->category,
            'wholesale_price' => $row['wholesale_price'] ?? null,
            'retail_price' => $row['retail_price'] ?? null,
        ]);
    }
}
