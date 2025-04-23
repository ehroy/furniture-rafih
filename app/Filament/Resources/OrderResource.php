<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart'; // Icon di sidebar
    protected static ?string $navigationGroup = 'E-Commerce'; // Bisa disesuaikan
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return \App\Models\Order::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; // warna badge (merah)
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')->required(),
                Forms\Components\TextInput::make('buyer_email')->email()->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('shipping_address'),
                Forms\Components\TextInput::make('total_price')->numeric()->required(),
 
                Repeater::make('items')
                ->relationship('items') // Menghubungkan dengan relasi `items` di Order
                ->schema([
                    Select::make('product_id')
                        ->relationship('product', 'name')
                        ->label('Product')
                        ->required(),

                    TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                    TextInput::make('price')
                        ->label('Price')
                        ->numeric()
                        ->minValue(0)
                        ->required(),

                    Select::make('status')
                        ->options([
                            'pending'    => 'Pending',
                            'confirmed'  => 'Confirmed',
                            'processing' => 'Processing',
                            'completed'  => 'Completed',
                            'cancelled'  => 'Cancelled',
                        ])
                        ->label('Status')
                        ->default('pending')
                        ->required(),
    ])
    ->columns(2) // Agar lebih rapi dalam tampilan
    ->collapsible(), // Bisa dilipat untuk lebih ringkas
                
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('buyer_email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->sortable()
                ->badge() // Tambahkan badge agar warna terlihat jelas
                ->color(fn ($state) => match ($state) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'processing' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary',
                }),
                Tables\Columns\TextColumn::make('total_price')->sortable()->money(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label("pesanan dibuat"),
                Tables\Columns\TextColumn::make('confirmed_at')->dateTime()->sortable()->label("pesanan dikonfirmasi"),
                Tables\Columns\TextColumn::make('processed_at')->dateTime()->sortable()->label("pesanan diproses"),
                Tables\Columns\TextColumn::make('completed_at')->dateTime()->sortable()->label("pesanan selesai"),
                Tables\Columns\TextColumn::make('canceled_at')->dateTime()->sortable()->label("pesanan dibatalkan"),


                // Menampilkan daftar produk dalam satu kolom
                Tables\Columns\TextColumn::make('items.product.name')
                    ->label('Products')
                    ->formatStateUsing(fn ($record) => $record->items->pluck('product.name')->join(', '))
                    ->sortable()
                    ->searchable(),
                
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('Waktu')
                    ->options([
                        'today' => 'Hari Ini',
                        '7days' => '7 Hari Terakhir',
                        '30days' => '30 Hari Terakhir',
                    ])
                    ->query(function ($query, $data) {
                        if ($data === 'today') {
                            return $query->whereDate('created_at', Carbon::today());
                        } elseif ($data === '7days') {
                            return $query->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()]);
                        } elseif ($data === '30days') {
                            return $query->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                
                BulkAction::make('bulkUpdateStatus')
                ->label('Ubah Status Massal')
                ->icon('heroicon-o-pencil-square') // Ikon opsional
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Status Baru')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'processing' => 'Processing',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required(),
                ])
                ->action(function (\Illuminate\Support\Collection $records, array $data) {
                    foreach ($records as $record) {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    }
                })
                ->deselectRecordsAfterCompletion(true)
                ->requiresConfirmation()
            ]);
    }


    public static function getRelations(): array
    {
        return [
            // \App\Filament\Resources\OrderItemsResource\RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
