<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
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
                Excel::import(new ProductImport, $data['file']->getRealPath());
            })
            ->successNotificationTitle('Produk berhasil diimport!'),
        ];
    }
   
}
