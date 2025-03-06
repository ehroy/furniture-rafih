<?php

namespace App\Filament\Resources\WoodResource\Pages;

use App\Filament\Resources\WoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWood extends ListRecords
{
    protected static string $resource = WoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
