<?php

namespace App\Filament\Resources\WoodResource\Pages;

use App\Filament\Resources\WoodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWood extends EditRecord
{
    protected static string $resource = WoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
