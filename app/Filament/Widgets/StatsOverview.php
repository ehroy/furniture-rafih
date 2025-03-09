<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products' , \App\Models\Product::count()),
            Stat::make('Total Categories',\App\Models\Category::count()),
            Stat::make('Total SubCategories' , \App\Models\SubCategory::count()),
            Stat::make('Product Views',\App\Models\Product::sum('views').'x'),
            Card::make('Total Orders', Order::count()),
            Card::make('Pending Orders', Order::where('status', 'pending')->count()),
            Card::make('Confirmed Orders', Order::where('status', 'confirmed')->count()),
            Card::make('Completed Orders', Order::where('status', 'completed')->count()),
            Card::make('Processing Orders', Order::where('status', 'processing')->count()),
            Card::make('Cancelled Orders', Order::where('status', 'cancelled')->count()),


        ];
    }
}
