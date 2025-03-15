<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DynamicSheetImport implements WithMultipleSheets
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function sheets(): array
    {
        Log::info('📌 DynamicSheetImport dijalankan untuk file: ' . $this->filePath);

        // Ambil semua sheet dari file
        $sheets = Excel::toArray([], $this->filePath);
        if (empty($sheets)) {
            Log::error('⚠️ Tidak ada sheet dalam file Excel!');
            return [];
        }

        Log::info('📌 Jumlah sheet ditemukan: ' . count($sheets));
        // dd($sheets);
        $sheetImports = [];
        foreach ($sheets as $index => $sheet) {
            $sheetImports[$index] = new EachSheetImport();
        }
        // dd($sheetImports);

        return $sheetImports;
    }
}