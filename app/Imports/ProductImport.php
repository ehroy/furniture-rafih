<?php


namespace App\Imports;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\SubCategory;
use App\Models\ProductVariant;
use App\Models\Wood;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Lewati header
        $rows->shift();

        foreach ($rows as $row) {
            if (!$row[0]) continue; // Lewati jika tidak ada data

            Log::info('Processing Row:', [$row]);

            // ✅ Cek kategori
            $category = Category::firstOrCreate(['name' => trim($row[1])]);

            // ✅ Cek subkategori
            $subCategory = SubCategory::firstOrCreate([
                'name' => trim($row[2]),
                'category_id' => $category->id,
            ]);

            // ✅ Cek produk berdasarkan SKU
            $product = Product::firstOrCreate(
                ['code_sku' => trim($row[4])],
                [
                    'sub_category_id' => $subCategory->id,
                    'name' => trim($row[3]),
                    'slug' => Str::slug(trim($row[3])),
                    'width' => $row[5],
                    'depth' => $row[6],
                    'height' => $row[7],
                    'price' => $row[8],
                    'content' => $row[9],
                    'image' => $row[10] ?? 'default.png',
                    'active' => $row[11] ?? 1,
                    'recomended' => $row[12] ?? 0,
                ]
            );

            // ✅ Cek varian hanya jika Wood dan Color diisi
            if (!empty($row[13]) && !empty($row[14])) {
                // **Normalisasi Nama Kayu**
                $woodName = strtolower(trim($row[13]));
                $wood = Wood::whereRaw('LOWER(name) = ?', [$woodName])->first();
                if (!$wood) {
                    // Jika tidak ada yang cocok, buat wood baru
                    $wood = Wood::create(['name' => ucfirst($woodName)]);
                }

                // **Normalisasi Nama Warna**
                $colorName = strtolower(trim($row[14]));
                $color = Color::whereRaw('LOWER(name) = ?', [$colorName])->first();

                // Jika warna tidak ditemukan, coba cari yang mirip
                if (!$color) {
                    $color = Color::where('name', 'LIKE', "%{$colorName}%")->first();
                }

                // Jika tetap tidak ada warna yang cocok, gunakan warna default
                if (!$color) {
                    $color = Color::first(); // Ambil warna pertama yang tersedia
                }

            
                // ✅ Cek apakah varian sudah ada
                $variantExists = ProductVariant::where([
                    'product_id' => $product->id,
                    'wood_id' => $wood->id,
                    'color_id' => $color->id,
                ])->exists();

                if (!$variantExists) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'wood_id' => $wood->id,
                        'color_id' => $color->id,
                        'price' => $row[15] ?? 0,
                        'stock' => $row[16] ?? 100,
                    ]);
                }
            }
        }
    }
}
