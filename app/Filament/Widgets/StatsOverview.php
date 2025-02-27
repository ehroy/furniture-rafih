<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products' , \App\Models\Product::count()),
            Stat::make('Total Categories',\App\Models\Category::count()),
            Stat::make('Total SubCategories' , \App\Models\SubCategory::count()),
            Stat::make('Product Views',\App\Models\Product::sum('views').'x')
        ];
    }
}
