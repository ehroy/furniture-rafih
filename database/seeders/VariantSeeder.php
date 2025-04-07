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
        ['name' => 'Tiger'],
        ['name' => 'Teak'],
        ['name' => 'Old Teak'],
    ];

    // Data untuk tabel color
    $colors = [
        ['name' => 'Default', 'code_palete' => '#F5F5F5'],  // Light Gray
        ['name' => 'Dbgsb', 'code_palete' => '#EED9B6'],     // Beige tone
        ['name' => 'Grey', 'code_palete' => '#808080'],      // Standard Gray
        ['name' => 'Silk', 'code_palete' => '#C8BFB5'],      // Soft silk tone
        ['name' => 'Teak', 'code_palete' => '#996633'],      // Teak wood color
        ['name' => 'Ort', 'code_palete' => '#D0F0C0'],       // Light greenish tone
    ];

    // Insert data ke database
    Wood::insert($woods);
    Color::insert($colors);
}
}
