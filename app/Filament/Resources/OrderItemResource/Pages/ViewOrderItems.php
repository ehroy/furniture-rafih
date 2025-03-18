<?php
namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderItemResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
