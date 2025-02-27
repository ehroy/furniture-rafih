<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductRecommend extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'sub_category_id' => 1,
                'slug' => 'modern-sofa',
                'name' => 'Modern Sofa',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A comfortable modern sofa with stylish design.',
                'price' => 1500000,
                'views' => 200,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 2,
                'slug' => 'elegant-chair',
                'name' => 'Elegant Chair',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'An elegant chair perfect for any room.',
                'price' => 750000,
                'views' => 150,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 3,
                'slug' => 'wooden-table',
                'name' => 'Wooden Table',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A sturdy wooden table for dining or work.',
                'price' => 1200000,
                'views' => 180,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 4,
                'slug' => 'luxury-bed',
                'name' => 'Luxury Bed',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A luxury bed for a comfortable sleep.',
                'price' => 2000000,
                'views' => 250,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 5,
                'slug' => 'office-desk',
                'name' => 'Office Desk',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'An office desk designed for productivity.',
                'price' => 900000,
                'views' => 300,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 6,
                'slug' => 'cozy-armchair',
                'name' => 'Cozy Armchair',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A cozy armchair perfect for reading.',
                'price' => 500000,
                'views' => 120,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 7,
                'slug' => 'minimalist-shelf',
                'name' => 'Minimalist Shelf',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A minimalist shelf for modern homes.',
                'price' => 650000,
                'views' => 90,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 8,
                'slug' => 'outdoor-chair',
                'name' => 'Outdoor Chair',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A comfortable chair for outdoor relaxation.',
                'price' => 300000,
                'views' => 80,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 9,
                'slug' => 'classic-dresser',
                'name' => 'Classic Dresser',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A classic dresser for storing clothes.',
                'price' => 1100000,
                'views' => 160,
                'recomended' => true,
                'active' => true,
            ],
            [
                'sub_category_id' => 10,
                'slug' => 'kids-bunk-bed',
                'name' => 'Kids Bunk Bed',
                'image' => '/assets/images/pink-float-chair.png',
                'content' => 'A fun bunk bed for kids.',
                'price' => 1300000,
                'views' => 220,
                'recomended' => true,
                'active' => true,
            ],
        ]);
    }
}
