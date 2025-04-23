<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Linker;
use App\Models\Product;
use App\Models\Category;
use App\Models\SocialMedia;
use App\Models\SubCategory;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Helpers\SettingsHelper;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class JustOrangeController extends Controller
{
    public $Global;
    public function __construct()
    {
        $this->Global['Settings'] = SettingsHelper::getSettings();
        $this->Global['currentUrl'] = url('/');
    }

    public function index(Request $request)
    {
            $cat = $request->get('category'); // slug
            $subSlug = $request->get('subcategory'); // slug
            $filter = $request->get('filter');
            
            $selectedSubCategory = null;
            $category = null;
            $data['SubCategories'] = collect();
            
            if ($cat) {
                $category = Category::where('slug', $cat)->first();
            
                if ($category) {
                    // Ambil semua subcategory dari category tersebut
                    $data['SubCategories'] = SubCategory::where('category_id', $category->id)->get();
            
                    if ($subSlug) {
                        $selectedSubCategory = SubCategory::where('slug', $subSlug)
                            ->where('category_id', $category->id)
                            ->first();
                    }
                }
            } else {
                // ✅ Jika tidak ada category, tetap ambil semua subcategory untuk ditampilkan
                $data['SubCategories'] = SubCategory::with('category')->latest()->limit(10)->get();
            }

            if ($filter === null) {
                if ($selectedSubCategory) {
                    // Jika ada subcategory, ambil produk berdasarkan subcategory
                    $data['Products'] = Product::where('sub_category_id', $selectedSubCategory->id)
                        ->orderBy('id', 'desc')
                        ->limit(8)
                        ->with(['subcategory', 'variants.wood', 'variants.color', 'variants'])
                        ->get();
                } elseif ($category) {
                    // Jika hanya ada category, ambil produk dari semua subcategory dalam category itu
                    $subIds = $data['SubCategories']->pluck('id');

                    $data['Products'] = Product::whereIn('sub_category_id', $subIds)
                        ->orderBy('id', 'desc')
                        ->limit(8)
                        ->with(['subcategory', 'variants.wood', 'variants.color', 'variants'])
                        ->get();
                } else {
                    // Tanpa kategori atau subkategori, ambil default
                    $data['Products'] = Product::orderBy('id', 'desc')
                        ->limit(8)
                        ->with(['subcategory', 'variants.wood', 'variants.color', 'variants'])
                        ->get();
                }
            }
    else {
            if ($filter == 'all') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->get();
            } elseif ($filter == 'new') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('id', 'desc')->get();
            } elseif ($filter == 'populer') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('views', 'desc')->get();
            } elseif ($filter == 'asc_harga') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('price', 'asc')->get();
            } elseif ($filter == 'desc_harga') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('price', 'desc')->get();
            }else if($filter == 'recommended')
            {
                $data['Products'] = Product::where('recomended' , true)->with->with(['subcategory','variants.wood','variants.color','variants'])->orderBy('id','desc')->get();
            }else{
                $data['Products'] = Product::whereHas('subcategory.category', function ($query) use ($filter) {
                    $query->where('slug', $filter);
                })->with(['subcategory.category','variants.wood','variants.color','variants'])->get();

            }
        }
        $data['Gallery'] = Product::selectRaw('MIN(id) as id, sub_category_id, MIN(image) as image')
        ->whereNotNull('image') // Pastikan hanya mengambil produk dengan gambar
        ->groupBy('sub_category_id') // Ambil satu produk per subkategori
        ->with(['subcategory.category']) // Ambil data kategori dari subkategori
        ->orderBy('id', 'desc')->limit(12)
        ->get();
        $data['Categories'] = Category::with('products')->get();
        $data['ActiveCat'] = $cat;
        $data['Filter'] = $filter;
        $data['Global'] = $this->Global;
        $data['ProductsRecommended'] = Product::where('recomended',true)->limit(10)->with(['subcategory','variants.wood','variants.color','variants'])->get();
        $data['Testimonials'] = Testimonial::where('active',true)->limit(6)->get();
        $data['Socmed'] = SocialMedia::all();
        $data['Pages'] = Post::where('active',true)->get();

        return Inertia::render('justorange-default', $data);
    }
    public function getGallery(Request $request)
    {
        $data['Global'] = $this->Global;
        $data['Categories'] = Category::with('products')->get();
        $data['Gallery'] = Product::selectRaw('MIN(id) as id, sub_category_id, MIN(image) as image')
        ->whereNotNull('image') // Pastikan hanya mengambil produk dengan gambar
        ->groupBy('sub_category_id') // Ambil satu produk per subkategori
        ->with(['subcategory.category']) // Ambil data kategori dari subkategori
        ->orderBy('id', 'desc')
        ->get();
        $data['Pages'] = Post::where('active', true)->get();
        $data['Socmed'] = SocialMedia::all();
        // dd($data);
        return Inertia::render('galery', $data);
    }
    public function getPage(Request $request)
    {
        $posts = Post::where('slug', $request->page)->first();
        if ($posts) {
            $data['page'] = $request->page;
            $data['post'] = $posts;
            $data['Categories'] = Category::all();
            $data['Global'] = $this->Global;

            return Inertia::render('pages', $data);
        } else {
            return Inertia::location(url('/'));
        }
    }

    public function getProducts(Request $request)
    {
        $cat = $request->get('category'); // string atau null
        $subGet = $request->get('subcategory');
        
        if ($cat === null) {
            $sub = SubCategory::orderBy('id', 'desc')->limit(5)->get();
        } else {
            $category = Category::where('slug', $cat)->first();
        
            $sub = $category
                ? SubCategory::where('category_id', $category->id)->get()
                : collect(); // return empty collection kalau slug tidak ditemukan
        }
        $filter = empty($request->get('filter')) ? null : $request->get('filter');

        if ($filter == null) {
            $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->limit(12)->get();
        } else {
            if ($filter == 'all') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->get();
            } elseif ($filter == 'new') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('id', 'desc')->get();
            } elseif ($filter == 'populer') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('views', 'desc')->get();
            } elseif ($filter == 'asc_harga') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('price', 'asc')->get();
            } elseif ($filter == 'desc_harga') {
                $data['Products'] = Product::with(['subcategory','variants.wood','variants.color','variants'])->orderBy('price', 'desc')->get();
            }else if($filter == 'recommended')
            {
                $data['Products'] = Product::where('recomended' , true)->with(['subcategory','variants.wood','variants.color','variants'])->orderBy('id','desc')->get();
            }
            else if($filter == 'search')
            {
                $query = $request->get('q');
                $data['Products'] =  Product::where('name', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%')
                ->with(['subcategory','variants.wood','variants.color','variants'])
                ->get();
                $data['FilterQuery'] = $query;
            }else{
                $data['Products'] = Product::whereHas('subcategory.category', function ($query) use ($filter) {
                    $query->where('slug', $filter);
                })->with(['subcategory.category','variants.wood','variants.color','variants'])->get();
            }
        }
        $data['SubCategories'] = $sub;
        $data['Categories'] = Category::all();
        $data['ActiveCat'] = $cat;
        $data['Filter'] = $filter;
        $data['Socmed'] = SocialMedia::all();
        $data['Pages'] = Post::where('active',true)->get();
        $data['Global'] = $this->Global;


        return Inertia::render('products/index', $data);
    }

    public function detailProduct(Request $request)
    {
        if(!$request->slug){
            return Inertia::location(url('/'));
        }
        $data['product'] = Product::where('slug', $request->slug)->with(['subcategory','variants.wood','variants.color','variants'])->first();
        $data['Products'] = Product::where('sub_category_id', $data['product']->sub_category_id)->orderBy('views', 'desc')->with(['subcategory','variants.wood','variants.color','variants'])->limit(4)->get();
        $data['Socmed'] = SocialMedia::all();
        $data['Pages'] = Post::where('active',true)->get();
        $data['Category'] = Category::find($data['product']->subcategory->category_id);
        $data['Categories'] = Category::all();
        $data['Global'] = $this->Global;

        if ($data['product']) {
            return Inertia::render('products/detail', $data);
        } else {
            return Inertia::location(url('/'));
        }
    }

    public function getProductByCategory(Request $request)
    {
        try {
        $category = Category::find($request->id);
        $subCat = SubCategory::where('category_id' , $category->id);
        $subGet = empty($request->get('sub')) ? null : $request->get('sub');
        $data['Products'] = ($subGet == null) ? Product::where('sub_category_id',$subCat->first()->id)->orderBy('id', 'desc')->with(['subcategory','variants.wood','variants.color','variants'])->get() : Product::where('sub_category_id', (int)$subGet)->orderBy('id', 'desc')->with(['subcategory','variants.wood','variants.color','variants'])->get();
        $data['Categories'] = Category::all();
        $data['SubCategories'] = SubCategory::where('category_id' , $category->id)->get();
        $data['ActiveCat'] = $subGet;
        $data['Category'] = $category;
        $data['Socmed'] = SocialMedia::all();
        $data['Pages'] = Post::where('active',true)->get();
        $data['subCategory'] = ($subCat==null) ? SubCategory::all() : SubCategory::find($subGet);
        $data['Global'] = $this->Global;

        if ($data['Products']) {
            return Inertia::render('products/category', $data);
        } else {
            return Inertia::location(url('/'));
        }

        } catch (\Throwable $th) {
            return Inertia::location(url('/'));
        }
    }
    public function checkout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'address' => 'required|string',
            'cart' => 'required|array',
            'cart.*.name' => 'required|string',
            'cart.*.price' => 'required|numeric',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.selectedColor.name' => 'nullable|string',
            'cart.*.selectedWoods.name' => 'nullable|string',
        ]);
    
        // Simpan order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'buyer_email' => $request->email,
            'total_price' => collect($request->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'shipping_address' => $request->address,
        ]);
    
        foreach ($request->cart as $item) {
            $variant = ProductVariant::where('product_id', $item['id'])
                ->whereHas('wood', function ($query) use ($item) {
                    $query->where('name', $item['selectedWoods']['name'] ?? null);
                })
                ->whereHas('color', function ($query) use ($item) {
                    $query->where('name', $item['selectedColor']['name'] ?? null);
                })
                ->first();
    
            $orderType = 'preorder';
    
            if ($variant && $variant->stock >= $item['quantity']) {
                $orderType = 'ready';
                $variant->decrement('stock', $item['quantity']);
            }
    
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'order_type' => $orderType,
            ]);
        }
    
        // Kirim email
        Mail::to($request->email)->send(new OrderMail($order, $request->cart));
        Mail::to(env('ADMIN_EMAIL'))->send(new OrderMail($order, $request->cart));
    
        return redirect()->route('cart.success', ['order_number' => $order->order_number]);
    }
    
    
    public function checkoutSuccess($order_number)
    {
        try{

            $data['order'] = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
            $data['Global'] = $this->Global;
            return Inertia::render('CheckoutSuccess', $data);
        } catch (\Throwable $th) {
            return Inertia::render('error');
        }
    }
    public function cart()
    {
        $data['Global'] = $this->Global;
        return Inertia::render('cart', $data);
    }


    public function linker()
    {

        $data['linker'] = Linker::all();
        $data['Global'] = $this->Global;

        return Inertia::render('linker', $data);
    }

    public function redirector(Request $request): RedirectResponse
    {
        $label = $request->label;
        $linker = Linker::where('label' , $label)->first();
        $linker->click = $linker->click+1;
        $linker->save();
        return redirect($linker->url);
    }
}
