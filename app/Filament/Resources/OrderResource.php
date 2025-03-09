<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $pluralLabel = 'Orders';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('order_number')
                    ->label('Order Number')
                    ->disabled(),

                TextInput::make('buyer_email')
                    ->label('Buyer Email')
                    ->email()
                    ->disabled(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->afterStateUpdated(fn (Model $record, string $state) => static::updateStatusDates($record, $state)),

                DateTimePicker::make('confirmed_at')
                    ->label('Confirmed At')
                    ->disabled(),

                DateTimePicker::make('processed_at')
                    ->label('Processed At')
                    ->disabled(),

                TextInput::make('total_price')
                    ->label('Total Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),

                TextInput::make('shipping_address')
                    ->label('Shipping Address')
                    ->disabled(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable(),

                TextColumn::make('buyer_email')
                    ->label('Buyer Email')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'pending' => 'gray',
                        'confirmed' => 'blue',
                        'processing' => 'yellow',
                        'completed' => 'green',
                        'cancelled' => 'red',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('IDR'),

                TextColumn::make('confirmed_at')
                    ->label('Confirmed At')
                    ->dateTime(),

                TextColumn::make('processed_at')
                    ->label('Processed At')
                    ->dateTime(),
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
            ]);
    }

    public static function updateStatusDates(Model $order, string $status): void
    {
        if ($status === 'confirmed' && !$order->confirmed_at) {
            $order->confirmed_at = now();
        }

        if ($status === 'processing' && !$order->processed_at) {
            $order->processed_at = now();
        }

        $order->save();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
