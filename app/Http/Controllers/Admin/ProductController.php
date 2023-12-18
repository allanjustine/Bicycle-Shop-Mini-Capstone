<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })
            ->orWhereHas('category', function ($categoryQuery) use ($search) {
                $categoryQuery->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.products.searched', compact('products', 'search'));
    }

    public function index(Product $product)
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'description'           => 'nullable',
            'price'                 => 'required',
            // 'category_id'           => 'required|exists:categories,id',
            'category_id'           => 'required',
            'image'                 => 'image',
        ]);

        $imagePath = $request->file('image')->store('images/products', 'public');


        $product = Product::create([
            'name'                      => $request->name,
            'description'               => $request->description,
            'price'                     => $request->price,
            'category_id'               => $request->category_id,
            'image'                     => $imagePath,
        ]);


        $log_entry = Auth::user()->name . " added a new product: " . $product->name . " with the id# " . $product->id;
        event(new UserLog($log_entry));

        return redirect('/admin/products')->with('message', 'Product detail added successfully');
    }

    public function updateProduct(Product $product)
    {

        $categories = Category::all();
        return view('admin.products.edit', compact('categories', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'                  => 'required',
            'description'           => 'nullable',
            'price'                 => 'required|numeric',
            // 'category_id'           => 'required|exists:categories,id',
            'category_id'           => 'required',
            'image'                 => 'image',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);

            $imagePath = $request->file('image')->store('images/products', 'public');
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            'name'                      => $request->input('name'),
            'description'               => $request->input('description'),
            'price'                     => $request->input('price'),
            'category_id'               => $request->input('category_id'),
            'image'                     => $imagePath,
        ]);

        $log_entry = Auth::user()->name . " updated the product: " . $product->name . " with the id# " . $product->id;
        event(new UserLog($log_entry));

        return redirect('/admin/products')->with('message', 'Product updated successfully');
    }

    public function delete(Product $product)
    {
        $log_entry = Auth::user()->name . " deleted the product " . $product->name .  " with the id# " . $product->id;
        event(new UserLog($log_entry));

        Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect('/admin/products')->with('message', 'Product detail deleted successfully');
    }
}
