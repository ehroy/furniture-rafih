<?php
namespace App\Imports;

use App\Models\Product;
use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'sub_category_id' => SubCategory::where('name', $row['sub_category'])->value('id'), // Ambil ID berdasarkan nama kategori
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image'], // Pastikan path gambar sesuai
            'content' => $row['content'],
            'active' => $row['active'] ?? 0,
            'recomended' => $row['recomended'] ?? 0,
        ]);
    }
}
