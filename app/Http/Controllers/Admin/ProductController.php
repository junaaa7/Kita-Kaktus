<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadAndCompressImage($request->file('image'));
            $product->image = $imagePath;
        }
        
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $this->uploadAndCompressImage($request->file('image'));
            $product->image = $imagePath;
        }
        
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Upload dan kompres gambar
     */
    private function uploadAndCompressImage($image)
    {
        try {
            // Buat nama file unik
            $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = 'products/' . $fileName;
            
            // Cek apakah GD Library tersedia
            if (extension_loaded('gd')) {
                // Baca file gambar
                $imgInfo = getimagesize($image->getRealPath());
                
                if ($imgInfo === false) {
                    // Jika bukan gambar valid, upload biasa
                    return $image->store('products', 'public');
                }
                
                // Buat resource gambar berdasarkan tipe
                switch ($imgInfo[2]) {
                    case IMAGETYPE_JPEG:
                        $src = imagecreatefromjpeg($image->getRealPath());
                        if ($src) {
                            imagejpeg($src, $image->getRealPath(), 75);
                            imagedestroy($src);
                        }
                        break;
                    case IMAGETYPE_PNG:
                        $src = imagecreatefrompng($image->getRealPath());
                        if ($src) {
                            imagealphablending($src, true);
                            imagesavealpha($src, true);
                            imagepng($src, $image->getRealPath(), 8);
                            imagedestroy($src);
                        }
                        break;
                    default:
                        // Format tidak didukung, upload biasa
                        return $image->store('products', 'public');
                }
            }
            
            // Upload file yang sudah dikompres
            return $image->store('products', 'public');
            
        } catch (\Exception $e) {
            // Jika error, upload tanpa kompresi
            return $image->store('products', 'public');
        }
    }
}