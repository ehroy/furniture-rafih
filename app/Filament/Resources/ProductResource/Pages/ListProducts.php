<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Exports\ProductExport;
use App\Filament\Resources\ProductResource;
use App\Imports\DynamicSheetImport;
use App\Imports\EachSheetImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Imports\ProductImportMaster;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('import')
            ->label('Import Produk')
            ->icon('heroicon-o-rectangle-stack')
            ->color('success')
            ->form([
                \Filament\Forms\Components\FileUpload::make('file')
                    ->label('Upload File Excel')
                    ->required()
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
            ])
            ->action(function (array $data) {
                $filePath = storage_path('app/public/' . $data['file']);

                // Cek apakah file ada
                if (!file_exists($filePath)) {
                    dd("File tidak ditemukan: " . $filePath);
                }
                // $sheetData = Excel::toArray([], $filePath);
                
                // dd(array_keys($sheetData));

                Excel::import(new EachSheetImport, $filePath);
                
            })
            ->successNotificationTitle('Produk berhasil diimport!'),
        ];
    }
   
}
