<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with('variants')->get()->map(function ($product) {
            return [
                'id'              => $product->id,
                'sub_category_id' => $product->sub_category_id,
                'slug'            => $product->slug,
                'name'            => $product->name,
                'image'           => $product->image,
                'content'         => strip_tags($product->content), // Menghapus tag HTML jika ada
                'price'           => $product->price,
                'views'           => $product->views,
                'active'          => $product->active ? '1' : '0',
                'recomended'      => $product->recomended ? '1' : '0',
                'variants'        => $product->variants->map(fn ($v) => "{$v->wood_id},{$v->color_id},{$v->price},{$v->stock}")->implode('|'),
            ];
        });
    }

    public function headings(): array
    {
        return ['id', 'sub_category_id', 'slug', 'name', 'image', 'content', 'price', 'views', 'active', 'recomended', 'variants'];
    }
}
