<?php


namespace App\Imports;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\SubCategory;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Schema;
use App\Models\Wood;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    protected $lastData = [
        'category' => null,
        'sub_category' => null,
        'product' => null,
        'wood' => null,
        'color' => null,
    ];

    public function collection(Collection $rows)
    {
        $rows->shift(); // Lewati header

        foreach ($rows as $row) {
            if (!$row[0]) continue; // Lewati jika tidak ada data

            Log::info('Processing Row:', [$row]);

            // ✅ Gunakan data sebelumnya jika kosong
            $categoryName = trim($row[1]) ?: $this->lastData['category']->name ?? null;
            $subCategoryName = trim($row[2]) ?: $this->lastData['sub_category']->name ?? null;
            $productName = trim($row[3]) ?: $this->lastData['product']->name ?? null;
            $sku = trim($row[4]) ?: $this->lastData['product']->code_sku ?? null;
            $width = $row[5] ?: $this->lastData['product']->width ?? 0;
            $depth = $row[6] ?: $this->lastData['product']->depth ?? 0;
            $height = $row[7] ?: $this->lastData['product']->height ?? 0;
            $price = $row[8] ?: $this->lastData['product']->price ?? 0;
            $content = $row[9] ?: $this->lastData['product']->content ?? null;
            $image = $row[10] ?: $this->lastData['product']->image ?? 'default.png';
            $active = $row[11] ?? 1;
            $recommended = $row[12] ?? 0;

            // ✅ Cek kategori
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $this->lastData['category'] = $category;

            // ✅ Cek subkategori
            $subCategory = SubCategory::firstOrCreate([
                'name' => $subCategoryName,
                'category_id' => $category->id,
            ]);
            $this->lastData['sub_category'] = $subCategory;

            // ✅ Cek produk berdasarkan SKU
            $product = Product::firstOrCreate(
                ['code_sku' => $sku],
                [
                    'sub_category_id' => $subCategory->id,
                    'category_id' => $category->id,
                    'name' => $productName,
                    'slug' => Str::slug($productName),
                    'width' => $width,
                    'depth' => $depth,
                    'height' => $height,
                    'price' => $price,
                    'content' => $content,
                    'image' => [],
                    'active' => $active,
                    'recomended' => $recommended,
                ]
            );
            $this->lastData['product'] = $product;

            // ✅ Cek varian hanya jika Wood dan Color diisi
            if (!empty($row[13]) || !empty($row[14])) {
                $woodName = strtolower(trim($row[13]) ?: $this->lastData['wood']->name ?? null);
                $colorName = strtolower(trim($row[14]) ?: $this->lastData['color']->name ?? null);

                if ($woodName) {
                    $wood = Wood::whereRaw('LOWER(name) = ?', [$woodName])->first();
                    if (!$wood) {
                        $wood = Wood::create(['name' => ucfirst($woodName)]);
                    }
                    $this->lastData['wood'] = $wood;
                }

                if ($colorName) {
                    if (!Schema::hasTable('colors')) {
                        Schema::create('colors', function (Blueprint $table) {
                            $table->id();
                            $table->string('name')->unique();
                            $table->string('image')->nullable();
                            $table->timestamps();
                        });
                    }
                
                    $color = Color::whereRaw('LOWER(name) = ?', [strtolower($colorName)])->first();
                
                    if (!$color) {
                        $color = Color::where('name', 'LIKE', "%{$colorName}%")->first();
                    }
                
                    if (!$color) {
                        $color = Color::create([
                            'name' => $colorName,
                            'image' => 'https://placehold.co/600x400?text=No+Image', // Ganti URL sesuai kebutuhan
                        ]);
                    }
                
                    $this->lastData['color'] = $color;
                }

                if (isset($wood) && isset($color)) {
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
}
