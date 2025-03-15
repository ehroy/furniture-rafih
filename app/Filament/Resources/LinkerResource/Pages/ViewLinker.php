<?php

namespace App\Filament\Resources\LinkerResource\Pages;

use App\Filament\Resources\LinkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLinker extends ViewRecord
{
    protected static string $resource = LinkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
