<?php

namespace App\Filament\Resources\LinkerResource\Pages;

use App\Filament\Resources\LinkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinker extends EditRecord
{
    protected static string $resource = LinkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
