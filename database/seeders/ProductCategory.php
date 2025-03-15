<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Wood;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allWoods = Wood::all();
        $allColors = Color::all();
        $furniture = [
            "Living Room" => [
                "Seating" => [
                    "Sofa",
                    "Recliner Chair",
                    "Accent Chair",
                    "Loveseat",
                    "Sectional Sofa",
                    "Bean Bag",
                    "Rocking Chair",
                    "Armchair",
                    "Chaise Lounge"
                ],
                "Tables" => [
                    "Coffee Table",
                    "End Table",
                    "Console Table",
                    "Lift Top Coffee Table"
                ],
                "Storage" => [
                    "Bookshelf",
                    "TV Stand",
                    "Nightstand",
                    "Storage Bench",
                    "Ladder Shelf"
                ],
                "Miscellaneous" => [
                    "Ottoman",
                    "Room Divider",
                    "Gaming Chair",
                    "Lounge Chair"
                ]
            ],
            "Dining Room" => [
                "Tables" => [
                    "Dining Table",
                    "Dining Set",
                    "Dining Bench"
                ],
                "Seating" => [
                    "Bar Stool",
                    "High Chair"
                ],
                "Storage" => [
                    "Sideboard",
                    "Buffet Table",
                    "Dining Buffet",
                    "Dining Hutch",
                    "Wine Rack"
                ]
            ],
            "Bedroom" => [
                "Beds" => [
                    "Bed Frame",
                    "Murphy Bed",
                    "Bunk Bed",
                    "Futon"
                ],
                "Storage" => [
                    "Wardrobe",
                    "Chest of Drawers",
                    "Dresser",
                    "Nightstand",
                    "Toy Chest",
                    "Changing Table"
                ],
                "Vanity" => [
                    "Vanity Table",
                    "Vanity Stool"
                ]
            ],
            "Office" => [
                "Seating" => [
                    "Office Chair",
                    "Swivel Chair",
                    "Desk Chair",
                    "Gaming Chair"
                ],
                "Tables" => [
                    "Desk",
                    "Standing Desk"
                ],
                "Storage" => [
                    "File Cabinet",
                    "Bookshelf",
                    "Filing Cabinet"
                ]
            ],
            "Outdoor" => [
                "Seating" => [
                    "Patio Chair",
                    "Garden Bench",
                    "Deck Chair",
                    "Outdoor Sofa",
                    "Outdoor Lounge Chair",
                    "Outdoor Swing",
                    "Outdoor Bench",
                    "Outdoor Bar Stool",
                    "Outdoor Loveseat",
                    "Outdoor Ottoman"
                ],
                "Tables" => [
                    "Patio Table",
                    "Outdoor Dining Set",
                    "Outdoor Coffee Table",
                    "Outdoor Bistro Set",
                    "Outdoor Bar Table"
                ]
            ],
            "Storage" => [
                "Shoe Storage" => [
                    "Shoe Rack",
                    "Shoe Cabinet"
                ],
                "General Storage" => [
                    "Cupboard",
                    "Cabinet",
                    "Entryway Table",
                    "Hall Tree",
                    "Curio Cabinet",
                    "Corner Shelf",
                    "Console Cabinet",
                    "Wall Shelf",
                    "Utility Cart",
                    "Entry Bench",
                    "Hall Bench"
                ]
            ],
            "Miscellaneous" => [
                "Decor" => [
                    "Plant Stand",
                    "Mirror",
                    "Room Screen"
                ],
                "Seating" => [
                    "Foldable Chair",
                    "Kids Table"
                ],
                "Comfort" => [
                    "Hammock",
                    "Massage Chair"
                ],
                "Utility" => [
                    "Bar Cart"
                ]
            ]
        ];
        $woods = Wood::all();
        $colors = Color::all();
        foreach ($furniture as $category => $subcategories) {
            $makeCategory = new \App\Models\Category();
            $makeCategory->name = $category;
            $makeCategory->description = $category;
            $makeCategory->active = true;
            $makeCategory->save();

            echo "[{$category}] .................................. OK \n";
            
            foreach($subcategories as $sub=>$pro)
            {
                $subCat = new \App\Models\SubCategory();
                $subCat->name = $sub;
                $subCat->image = 'https://placehold.jp/3d4070/ffffff/200x200.png?css=%7B%22border-radius%22%3A%22100%%22%7D';
                $subCat->active = true;
                $subCat->category_id = $makeCategory->id;
                $subCat->save();
                echo "{$sub} => ".count($pro)."  ...................... OK\n";
            
                foreach($pro as $p){
                    echo "{$p} {$sub} ................................... OK \n";
                $product = new \App\Models\Product();
                $product->sub_category_id = $subCat->id;
                $product->name = $p;
                $product->code_sku =  "TW-" . Str::upper(Str::random(6));
                $product->width = rand(10,100);
                $product->depth = rand(10,100);
                $product->height = rand(10,100);
                $product->image = 'https://placehold.co/600x400?text=No+Image';
                $product->slug = Str::slug($p);
                $product->price = rand(0,5000000);
                $product->views = rand(0,100);
                $product->recomended = true;
                $product->active = false;
                $product->content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent cursus eros non lobortis aliquet. Suspendisse ullamcorper commodo luctus. Vestibulum quis est nec felis fringilla pellentesque. Nullam blandit urna nec diam semper aliquam. Nunc nec tortor sit amet mi interdum porta non ut dui. Proin nibh turpis, pellentesque elementum est in, pellentesque ultrices ipsum. Proin porta aliquam enim, vitae venenatis mauris pretium eu. Phasellus nec libero feugiat, posuere diam vel, ornare tellus. Praesent eget nisl libero. Duis non elit gravida, viverra tellus non, commodo libero. In risus sapien, pharetra sit amet cursus sed, molestie quis metus. Morbi congue odio odio, quis dapibus risus dignissim in. Quisque vel dui at lorem blandit venenatis a et leo. Phasellus sed lacinia eros, sit amet porta dui.

                Duis nec ligula non turpis euismod gravida. Quisque nulla arcu, luctus finibus tellus vel, efficitur iaculis lectus. Suspendisse luctus laoreet elementum. Fusce gravida semper hendrerit. Nulla imperdiet sapien consectetur interdum fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec ac eros sodales magna interdum venenatis molestie eget elit. Cras lorem velit, scelerisque non metus at, elementum ultrices lacus. Proin rhoncus justo quis magna maximus, ut tristique mi ornare. In finibus sed enim ac tempor. Proin sed tempus sapien, in mattis dolor. Nullam interdum erat sodales, pulvinar dui nec, elementum dolor.
                
                Morbi aliquet magna id tristique ultricies. Curabitur eu nulla felis. Aenean condimentum ligula ac magna feugiat, vitae porta erat porttitor. Donec posuere eros non rhoncus dapibus. Maecenas non urna iaculis erat cursus vehicula. Donec ut elementum ligula, in porta elit. Ut ultrices facilisis neque, suscipit vulputate sem. Mauris vehicula eget orci id viverra. Morbi imperdiet suscipit tellus vel blandit. Sed sem magna, pellentesque in ex eget, dictum lobortis lacus. Etiam convallis, purus vitae mollis euismod, ligula magna aliquet dolor, non dapibus augue sapien eleifend ante. Nam facilisis tortor at arcu auctor venenatis. Morbi venenatis accumsan ultrices. Mauris ultrices lobortis ex, ut tempor tellus malesuada eget.
                
                Donec tristique rhoncus orci vitae finibus. Nam rhoncus nisl eleifend, porttitor magna convallis, rutrum elit. Mauris fringilla magna a nibh tincidunt, ut commodo diam consectetur. Fusce luctus lacus nec feugiat finibus. Nulla facilisi. Nulla accumsan purus nunc, ac pellentesque ligula aliquet varius. Donec in nisl hendrerit, auctor enim id, pellentesque velit. Suspendisse dictum ipsum felis, in volutpat purus viverra ac.
                
                Sed molestie tempus feugiat. Vivamus et orci non ligula posuere tincidunt. Suspendisse dapibus finibus sodales. Aenean tincidunt quam enim, vel suscipit eros efficitur varius. Cras faucibus urna et libero condimentum lacinia. Duis malesuada risus lectus, eu ultricies lorem dignissim a. Suspendisse gravida ante suscipit est euismod sagittis.';

                $product->save();
                foreach ($woods as $wood) {
                    foreach ($colors as $color) {
                        $statusvariant = ProductVariant::create([
                            'product_id' => $product->id,
                            'wood_id' => $wood->id,
                            'color_id' => $color->id,
                            'price' => rand(500000, 5000000), // Harga random
                            'stock' => rand(1, 50) // Stok random
                        ]);
                        echo "[{$statusvariant}] .................................. OK \n";
                    }
                }
                }
            }
          

        }
    }
}
