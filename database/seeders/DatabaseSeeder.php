<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Color;
use App\Models\Wood;
use Database\Seeders\ProductRecommend;
use Database\Seeders\Testimoni;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        $links = [
            'tiktok' => 'https://www.tiktok.com/@iapropertyproject?_t=8jdfzny32cg&_r=1',
            'instagram' => 'https://instagram.com/iapropertyproject',
            'whatsapp' => 'https://wa.me/6287857580910',
            'line' => 'https://line.me/ti/p/vPzH86Oqo3',
            'shopee' => 'http://shopee.co.id/iaproject',
            'tokopedia' => 'https://tokopedia.link/Xlvh9NDNV9',
            'website' => 'http://localhost:8000',
        ];
        foreach ($links as $label => $url) {
            \App\Models\Linker::create(
                [
                    'label' => $label,
                    'url' => $url
                ]
            );

           if(!in_array($label,['website','tokopedia','shopee','line']))
           {
            \App\Models\SocialMedia::create(
                [
                    'type' => $label,
                    'link' => $url,
                    'icon'=> 'mdi mdi-'.$label
                ]
                );
           }
        }
        $this->call(VariantSeeder::class);
        $this->call(ProductCategory::class);
        $this->call(Testimoni::class);
        $this->call(ProductRecommend::class);
        $this->call(OrderSeeder::class);

        // $this->call(ShieldSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('123456789'), // Ganti dengan password yang diinginkan
        // ])->assignRole('super_admin');
        
       

        
    }
}
