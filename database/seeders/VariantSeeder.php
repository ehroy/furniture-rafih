<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Wood;
use App\Models\Color;

class VariantSeeder extends Seeder
{
    public function run()
    {
        // Data untuk tabel wood
        $woods = [
            ['name' => 'Jati'],
            ['name' => 'Mahoni'],
            ['name' => 'Sonokeling'],
            ['name' => 'Pinus'],
            ['name' => 'Mindi'],
        ];

        // Data untuk tabel color
        $colors = [
            ['name' => 'Merah', 'code_palete' => '#FF0000'],
            ['name' => 'Biru', 'code_palete' => '#0000FF'],
            ['name' => 'Hijau', 'code_palete' => '#008000'],
            ['name' => 'Kuning', 'code_palete' => '#FFFF00'],
            ['name' => 'Hitam', 'code_palete' => '#000000'],
        ];

        // Insert data ke database
        Wood::insert($woods);
        Color::insert($colors);
    }
}
