<?php

namespace App\Filament\Resources;

use App\Exports\ProductExport;
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
use App\Models\Category;
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
            // Pilih Category
            Forms\Components\Section::make('Informasi Produk')
            ->schema([
                Forms\Components\Grid::make(2) // Grid 2 kolom
                
                ->schema([
                 
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(Category::pluck('name', 'id'))
                        ->reactive()
                        ->required()
                        ->native(false)
                        ->default(fn ($record) => $record?->category_id)
                        ->afterStateUpdated(function (callable $set, callable $get) {
                            $categoryId = $get('category_id');
                            $subCategoryId = $get('sub_category_id');
                    
                            // Jika sub_category_id tidak valid untuk kategori baru, reset
                            $isValidSubCategory = SubCategory::where('category_id', $categoryId)
                                ->where('id', $subCategoryId)
                                ->exists();
                    
                            if (!$isValidSubCategory) {
                                $set('sub_category_id', null);
                            }
                        }),
                    Forms\Components\Select::make('sub_category_id')
                        ->label('Sub Category')
                        ->options(fn (callable $get) => 
                            $get('category_id') 
                                ? SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id')
                                : []
                        )
                        ->default(fn ($record) => $record?->sub_category_id)
                        ->required()
                        ->native(false)
                        ->reactive(),
                ]),

            // Informasi Dasar Produk
            Forms\Components\Grid::make(3) // Grid 3 kolom untuk kode & dimensi
                ->schema([
                    Forms\Components\TextInput::make('code_sku')
                        ->label('Product Code')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('width')
                        ->label('Width (cm)')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('depth')
                        ->label('Depth (cm)')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('height')
                        ->label('Height (cm)')
                        ->numeric()
                        ->required(),
                ]),

            // Nama dan Harga Produk
            Forms\Components\TextInput::make('name')
                ->label('Product Name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('price')
                ->label('Price')
                ->required()
                ->numeric()
                ->default(0)
                ->prefix('Rp')
                ->helperText('Isi dengan 0 jika harga tidak ingin ditampilkan'),

            // Upload Gambar
            Forms\Components\FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->imageEditor()
                ->optimize('png')
                ->resize(50)
                ->required()
                ->columnSpanFull(),

            // Deskripsi Produk
            Forms\Components\RichEditor::make('content')
                ->label('Product Description')
                ->required()
                ->columnSpanFull(),

            // Status Produk
            Forms\Components\Grid::make(2) // Grid 2 kolom untuk status
                ->schema([
                    Forms\Components\Toggle::make('active')
                        ->label('Active Status')
                        ->required(),

                    Forms\Components\Toggle::make('recomended')
                        ->label('Is Recommended?')
                        ->required(),
                ]),
        ])
        ->columnSpanFull(),

            // Varian Produk (Repeater)
            Forms\Components\Repeater::make('variants')
                ->relationship('variants')
                ->schema([
                    Forms\Components\Grid::make(6)
                        ->schema([
                            Forms\Components\Select::make('wood_id')
                                ->label('Kayu')
                                ->options(Wood::pluck('name', 'id'))
                                ->default(fn ($record) => $record?->wood_id)
                                ->required()
                                ->columnSpan(2),

                            Forms\Components\Select::make('color_id')
                                ->label('Warna')
                                ->options(Color::pluck('name', 'id'))
                                ->default(fn ($record) => $record?->color_id)
                                ->required()
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('stock')
                                ->label('Stok')
                                ->numeric()
                                ->required()
                                ->columnSpan(1)
                                ->default(100),
                        ])
                ])
                ->columnSpanFull()
        ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subcategory.category.name')
                    ->label('Category') // Beri label kategori
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('subcategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_sku')
                    ->searchable(),
                Tables\Columns\TextColumn::make('width')
                    ->searchable(),
                Tables\Columns\TextColumn::make('depth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('height')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
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
                Action::make('Export Produk')
                ->label('Export Produk')
                ->action(function () {
                    return Excel::download(new ProductExport, 'products.xlsx');
                })
                ->color('success'),
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
