<?php

namespace App\Filament\Resources\LinkerResource\Pages;

use App\Filament\Resources\LinkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinkers extends ListRecords
{
    protected static string $resource = LinkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
