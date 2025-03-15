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
            ['name' => 'Merah', 'code_palete' => 'bg-[#FF0000]'],
            ['name' => 'Biru', 'code_palete' => 'bg-[#0000FF]'],
            ['name' => 'Hijau', 'code_palete' => 'bg-[#008000]'],
            ['name' => 'Kuning', 'code_palete' => 'bg-[#FFFF00]'],
            ['name' => 'Hitam', 'code_palete' => 'bg-[#000000]'],
        ];

        // Insert data ke database
        Wood::insert($woods);
        Color::insert($colors);
    }
}
