<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WoodResource\Pages;
use App\Filament\Resources\WoodResource\RelationManagers;
use App\Models\Wood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class WoodResource extends Resource
{
    protected static ?string $model = Wood::class;

    protected static ?string $navigationIcon = 'heroicon-m-chevron-right';
    protected static ?string $navigationGroup = 'Product Variants';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->unique(Wood::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListWood::route('/'),
            'create' => Pages\CreateWood::route('/create'),
            'edit' => Pages\EditWood::route('/{record}/edit'),
        ];
    }
}
