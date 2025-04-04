<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductVariantResource\Pages;
use App\Filament\Resources\ProductVariantResource\RelationManagers;
use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Select, TextInput};
class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'heroicon-m-chevron-right';
    protected static ?string $navigationGroup = 'Gudang Product';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return \App\Models\ProductVariant::where('stock', '<', 1)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; // warna badge (merah)
    }

    public static function getNavigationLabel(): string
    {
        return 'Product Details'; // Ganti dengan nama yang diinginkan
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                ->relationship('product', 'name')
                ->required(),
                Select::make('wood_id')
                    ->relationship('wood', 'name')
                    ->required(),
                Select::make('color_id')
                    ->relationship('color', 'name')
                    ->required(),
                TextInput::make('price')->numeric()->nullable(),
                TextInput::make('stock')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                ->label('Produk')
                ->searchable(),
                Tables\Columns\TextColumn::make('product.code_sku')
                ->label('Code Sku')
                ->searchable(),
                Tables\Columns\ImageColumn::make('product.image')
                ->label('Produk')
                ->searchable(),
                Tables\Columns\TextColumn::make('wood.name')
                    ->label('Jenis Kayu')
                    ->searchable(),
            
                Tables\Columns\TextColumn::make('color.name')
                    ->label('Warna')
                    ->searchable(),
            
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money() // Menampilkan harga dalam format mata uang IDR
                    ->sortable(),
            
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
