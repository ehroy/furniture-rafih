<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubCategory;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Models\Color;
use App\Models\Wood;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Product & Category';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_category_id')->label('Sub Category')->options(SubCategory::all()->pluck('name','id'))->required()->native(false)->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp')
                    ->helperText('Isi dengan 0 jika harga tidak ingin di tampilkan'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->optimize('png')
                    ->resize(50)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
               
                Forms\Components\Toggle::make('active')
                    ->required(),
                Forms\Components\Toggle::make('recomended')->label('is Recommended?')->required(),
                Forms\Components\Repeater::make('variants')
                ->relationship('variants')
                ->schema([
                    Forms\Components\Select::make('wood_id')
                        ->label('Jenis Kayu')
                        ->options(Wood::pluck('name', 'id'))
                        ->required(),
            
                    Forms\Components\Select::make('color_id')
                        ->label('Warna')
                        ->options(Color::pluck('name', 'id'))
                        ->required(),
            
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
            
                    Forms\Components\TextInput::make('stock')
                        ->label('Stok')
                        ->numeric()
                        ->required(),
                ])
                ->columnSpanFull(1)            
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subcategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('recomended')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
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
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import Produk')
                ->icon('heroicon-o-cloud-upload')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Upload File Excel')
                        ->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                ])
                ->action(function (array $data) {
                    Excel::import(new ProductImport, $data['file']->getRealPath());
                })
                ->successNotificationTitle('Produk berhasil diimport!'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
