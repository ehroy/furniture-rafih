<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProductSheetImport implements ToCollection
{
    protected $sheetName;

    public function __construct($sheetName)
    {
        $this->sheetName = $sheetName;
    }

    public function collection(Collection $rows)
    {
        Log::info("Data dari sheet {$this->sheetName}: " . json_encode($rows));
        
        foreach ($rows as $row) {
            // Simpan atau proses data
            Log::info("Row: " . json_encode($row));
        }
    }
}
