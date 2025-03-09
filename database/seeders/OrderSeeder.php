<?php
namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 30) as $index) {
            $status = $faker->randomElement(['pending', 'confirmed', 'processing', 'completed', 'cancelled']);

            $confirmedAt = null;
            $processedAt = null;

            if ($status === 'confirmed') {
                $confirmedAt = now()->subDays(rand(1, 5));
            } elseif ($status === 'processing') {
                $confirmedAt = now()->subDays(rand(3, 7));
                $processedAt = now()->subDays(rand(1, 2));
            } elseif ($status === 'completed') {
                $confirmedAt = now()->subDays(rand(7, 10));
                $processedAt = now()->subDays(rand(3, 5));
            }

            $order = Order::create([
                'order_number' => strtoupper($faker->bothify('ORDER-###???')),
                'buyer_email' => $faker->safeEmail,
                'status' => $status,
                'confirmed_at' => $confirmedAt,
                'processed_at' => $processedAt,
                'total_price' => 0, // Akan diupdate nanti
                'shipping_address' => $faker->address,
            ]);

            $totalPrice = 0;
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get(); // Ambil produk acak dari database

            foreach ($products as $product) {
                $price = $product->price; // Gunakan harga dari produk
                $quantity = $faker->numberBetween(1, 3);
                $totalPrice += $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id, // Simpan product_id, bukan nama produk acak
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            // Update total price setelah semua item ditambahkan
            $order->update(['total_price' => $totalPrice]);
        }
    }
}
