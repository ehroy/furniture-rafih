<?php

namespace App\Filament\Resources\OrderItemsResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\OrderItem;
use App\Models\Product;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items'; // Pastikan ini sesuai dengan relasi di Order.php

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                // Menampilkan nama produk, bukan ID
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),

                // Menampilkan gambar produk
                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Product Image')
                    ->circular(), // Bisa dihapus jika ingin bentuk biasa

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'processing' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money() // Sesuaikan dengan mata uang
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
