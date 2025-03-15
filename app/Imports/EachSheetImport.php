<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EachSheetImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'UPLOAD' => new ProductImport(), // Gunakan nama sheet yang sesuai dari Excel
        ];
    }
}