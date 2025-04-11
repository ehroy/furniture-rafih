<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Sama seperti sebelumnya, ambil produk & blog
        foreach (\App\Models\Product::all() as $produk) {
            $sitemap->add(
                Url::create('/produk/' . $produk->slug)
                    ->setLastModificationDate($produk->updated_at)
            );
        }
        
    
        // Simpan ke file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
