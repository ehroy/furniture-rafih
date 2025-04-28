<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ColorResource\Pages;
use App\Filament\Resources\ColorResource\RelationManagers;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ColorResource extends Resource
{
    protected static ?string $model = Color::class;

    protected static ?string $navigationIcon = 'heroicon-m-chevron-right';
    protected static ?string $navigationGroup = 'Product Variants';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                FileUpload::make('image')
                    ->required()
                    ->multiple() // Untuk multiple image
                    ->label('Images') // Label untuk input
                    ->helperText('Upload multiple images')
                    ->image() // Optional, jika ingin menampilkan preview image
                    ->afterStateHydrated(function ($component, $state) {
                        // Pastikan kita hanya melakukan json_decode jika $state adalah string
                        return is_string($state) ? json_decode($state, true) : $state;
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('image')
            ->label('Images')
            ->formatStateUsing(function ($state) {
                // Periksa apakah $state adalah string dan pisahkan menggunakan koma
                if (is_string($state)) {
                    // Pisahkan string menjadi array berdasarkan koma
                    $images = explode(',', $state);

                    // Jika $state adalah array
                    $imageHtml = '<div style="display: flex; flex-wrap: wrap;">'; // Membuat container dengan display flex
                    foreach ($images as $image) {
                        // Gunakan asset() untuk mengakses gambar yang disimpan di public storage
                        $imageUrl = asset('storage/' . trim($image)); // Gunakan trim() untuk menghapus spasi jika ada

                        // Pastikan gambar bisa diakses, jika tidak tambahkan fallback
                        $imageHtml .= "<img src='$imageUrl' alt='Image' style='width: 50px; height: auto; margin-right: 5px; margin-bottom: 5px;'>"; // Menambahkan margin untuk jarak antar gambar
                    }
                    $imageHtml .= '</div>'; // Menutup container div
                    return $imageHtml;
                }
                return 'No Images'; // Jika tidak ada gambar
            })
            ->html()
        ])->filters([
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
            'index' => Pages\ListColors::route('/'),
            'create' => Pages\CreateColor::route('/create'),
            'edit' => Pages\EditColor::route('/{record}/edit'),
        ];
    }
}
