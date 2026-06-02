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
        // TAMBAHKAN ->onEachSide(2) untuk menampilkan nomor halaman di desktop
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10)->onEachSide(2);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $product->image = $this->uploadAndCompressImage($request->file('image'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $product->image = $this->uploadAndCompressImage($request->file('image'));
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    private function uploadAndCompressImage($image)
    {
        $destinationPath = public_path('uploads/products');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fileName = time() . '_' . Str::random(10) . '.webp';
        $fullPath = $destinationPath . '/' . $fileName;

        try {
            if (!extension_loaded('gd')) {
                $image->move($destinationPath, $fileName);
                return 'uploads/products/' . $fileName;
            }

            $imgInfo = getimagesize($image->getRealPath());

            if ($imgInfo === false) {
                $image->move($destinationPath, $fileName);
                return 'uploads/products/' . $fileName;
            }

            switch ($imgInfo[2]) {
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($image->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($image->getRealPath());
                    break;
                case IMAGETYPE_WEBP:
                    $src = imagecreatefromwebp($image->getRealPath());
                    break;
                default:
                    $image->move($destinationPath, $fileName);
                    return 'uploads/products/' . $fileName;
            }

            if (!$src) {
                $image->move($destinationPath, $fileName);
                return 'uploads/products/' . $fileName;
            }

            $width = imagesx($src);
            $height = imagesy($src);

            $maxSize = 900;

            if ($width > $height) {
                $newWidth = min($width, $maxSize);
                $newHeight = intval($height * ($newWidth / $width));
            } else {
                $newHeight = min($height, $maxSize);
                $newWidth = intval($width * ($newHeight / $height));
            }

            $resized = imagecreatetruecolor($newWidth, $newHeight);

            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            imagecopyresampled(
                $resized,
                $src,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            imagewebp($resized, $fullPath, 75);

            imagedestroy($src);
            imagedestroy($resized);

            return 'uploads/products/' . $fileName;

        } catch (\Exception $e) {
            $image->move($destinationPath, $fileName);
            return 'uploads/products/' . $fileName;
        }
    }
}