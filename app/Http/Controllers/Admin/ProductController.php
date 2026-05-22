<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }

            $imagePath = $this->uploadAndCompressImage($request->file('image'));
            $product->image = $imagePath;
        }
        
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
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
            $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('images/products');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if (extension_loaded('gd')) {
                $imgInfo = getimagesize($image->getRealPath());

                if ($imgInfo !== false) {
                    switch ($imgInfo[2]) {
                        case IMAGETYPE_JPEG:
                            $src = imagecreatefromjpeg($image->getRealPath());
                            if ($src) {
                                imagejpeg($src, $destinationPath . '/' . $fileName, 75);
                                imagedestroy($src);
                                return $fileName;
                            }
                            break;

                        case IMAGETYPE_PNG:
                            $src = imagecreatefrompng($image->getRealPath());
                            if ($src) {
                                imagealphablending($src, true);
                                imagesavealpha($src, true);
                                imagepng($src, $destinationPath . '/' . $fileName, 8);
                                imagedestroy($src);
                                return $fileName;
                            }
                            break;
                    }
                }
            }

            $image->move($destinationPath, $fileName);

            return $fileName;

        } catch (\Exception $e) {
            $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $fileName);

            return $fileName;
        }
    }
}