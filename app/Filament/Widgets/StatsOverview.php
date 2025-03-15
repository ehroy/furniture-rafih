<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            // Statistik Produk
            Stat::make('Total Products', Product::count())
                ->description('Jumlah semua produk')
                // ->icon('heroicon-o-cube')
                ->color('success'),

            Stat::make('Total Categories', Category::count())
                ->description('Jumlah kategori produk')
                // // ->icon('heroicon-o-collection')
                ->color('primary'),

            Stat::make('Total SubCategories', SubCategory::count())
                ->description('Jumlah sub-kategori')
                // // ->icon('heroicon-o-folder')
                ->color('info'),

            Stat::make('Product Views', Product::sum('views') . ' x')
                ->description('Total tampilan produk')
                // // ->icon('heroicon-o-eye')
                ->color('warning'),

            // Statistik Pesanan
            Stat::make('Total Orders', Order::count())
                ->description('Jumlah semua pesanan')
                // // ->icon('heroicon-o-shopping-cart')
                ->color('gray'),

            Stat::make('Pending Orders', Order::where('status', 'pending')->count())
                ->description('Pesanan yang menunggu konfirmasi')
                // // ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Confirmed Orders', Order::where('status', 'confirmed')->count())
                ->description('Pesanan yang sudah dikonfirmasi')
                // // ->icon('heroicon-o-check')
                ->color('success'),

            Stat::make('Processing Orders', Order::where('status', 'processing')->count())
                ->description('Pesanan yang sedang diproses')
                // // ->icon('heroicon-o-refresh')
                ->color('blue'),

            Stat::make('Completed Orders', Order::where('status', 'completed')->count())
                ->description('Pesanan yang telah selesai')
                // // ->icon('heroicon-o-check-circle')
                ->color('green'),

            Stat::make('Cancelled Orders', Order::where('status', 'cancelled')->count())
                ->description('Pesanan yang dibatalkan')
                // // ->icon('heroicon-o-x-circle')
                ->color('red'),
        ];
    }
    
}
