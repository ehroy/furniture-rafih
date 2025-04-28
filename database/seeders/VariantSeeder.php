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
        ['name' => 'Default', 'image' => ['']],  // Light Gray
        ['name' => 'Dbgsb', 'image' => ['']],     // Beige tone
        ['name' => 'Grey', 'image' => ['']],      // Standard Gray
        ['name' => 'Silk', 'image' => ['']],      // Soft silk tone
        ['name' => 'Teak', 'image' => ['']],      // Teak wood color
        ['name' => 'Ort', 'image' => ['']],       // Light greenish tone
    ];

    // Insert data ke database
    Wood::insert($woods);
    Color::insert($colors);
}
}
