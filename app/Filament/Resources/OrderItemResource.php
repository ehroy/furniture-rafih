<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Log;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart'; // Icon di sidebar
    protected static ?string $navigationGroup = 'E-Commerce'; // Bisa disesuaikan
    protected static ?int $navigationSort = 1;
    public static function getNavigationLabel(): string
    {
        return 'Semua Status Pesanan'; // Ganti dengan nama yang diinginkan
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->columnSpanFull()
                    ->native(false),
                Select::make('order_id')
                    ->relationship('order', 'order_number')
                    ->required()
                    ->columnSpanFull()
                    ->native(false),
                Select::make('product_variant_id')
                    ->options(function ($state) {
                        // Ambil nilai product_id dan color_id dari state form
                        $productId = $state['product_id'] ?? null; // Pastikan ini sudah ada di state
                        $colorId = $state['color_id'] ?? null; // Pastikan ini sudah ada di state
                
                        // Filter berdasarkan product_id dan color_id, jika ada
                        $variants = \App\Models\ProductVariant::with('wood', 'color')
                            ->when($productId, function ($query) use ($productId) {
                                return $query->where('product_id', $productId);
                            })
                            ->when($colorId, function ($query) use ($colorId) {
                                return $query->whereHas('color', function ($q) use ($colorId) {
                                    $q->where('id', $colorId);
                                });
                            })
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->id => $item->wood->name . ' - ' . $item->color->name, // Menampilkan nama wood dan color
                                ];
                            });
                
                        return $variants;
                    })
                    ->required()
                    ->columnSpanFull()
                    ->native(false),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->label('Qty')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'confirmed'  => 'Confirmed',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                        'cancelled'  => 'Cancelled',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        if ($record) { // Pastikan record tidak null
                            $record->updateStatus($state);
                        } else {
                            Log::error('Record not found in afterStateUpdated');
                        }
                    })
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
              
                TextColumn::make('order.order_number') // Ambil nama customer dari relasi order
                ->label('Order Name')
                ->sortable()
                ->searchable(),
            
                TextColumn::make('product.name') // Ambil nama produk dari relasi product
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('productVariant.color.name') // Ambil nama produk dari relasi product
                    ->label('Color')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('productVariant.wood.name') // Ambil nama produk dari relasi product
                    ->label('Wood')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('order_type')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ready' => 'success',   // Hijau
                        'preorder' => 'warning', // Kuning/oranye
                        default => 'gray',
                    })
                    ->label('Order Type'),
                TextColumn::make('price')->sortable()->money(),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('status')->sortable()->badge()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'processing' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary',
                })
                ->sortable(),
                TextColumn::make('confirmed_at_formatted')->label('Confirmed At')->sortable()->badge()
                ->color(fn ($state) => match ($state) {
                    'Belum dikonfirmasi' => 'secondary',
                    default => 'info',
                }),
                TextColumn::make('processing_at_formatted')->label('Processing At')->sortable()->badge()
                ->color(fn ($state) => match ($state) {
                    'Belum diproses' => 'secondary',
                    default => 'primary',
                }),
                TextColumn::make('completed_at_formatted')->label('Completed At')->sortable()->badge()
                ->color(fn ($state) => match ($state) {
                    'Belum selesai' => 'secondary',
                    default => 'success',
                }),
                TextColumn::make('cancelled_at_formatted')->label('Cancelled At')->sortable()->badge()
                ->color(fn ($state) => match ($state) {
                    'Tidak dibatalkan' => 'secondary',
                    default => 'danger',
                }),
            
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'confirmed'  => 'Confirmed',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                        'cancelled'  => 'Cancelled',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulkUpdateStatus')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'edit'  => Pages\EditOrderItem::route('/{record}/edit'),
            'view'  => Pages\EditOrderItem::route('/{record}'),
        ];
    }
}
