<?php

namespace App\Http\Controllers\NormalView;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function productList()
    {
        $products = Product::all();

        return view('normal-view.pages.index', compact('products'));
    }

    public function categoryList(Category $category)
    {

        $categories = Category::orderBy('name', 'asc')->with('products')->get();

        return view('normal-view.pages.category-list', compact('category', 'categories'));
    }

    public function orders()
    {

        $orders = Order::orderBy('created_at', 'asc')->where('user_id', auth()->id())->with('product')->paginate(10);

        return view('normal-view.orders.index', compact('orders'));
    }
    public function confirmQuantity(Product $product)
    {
        return view('normal-view.orders.confirm-quantity', compact('product'));
    }

    public function orderCreate(Request $request, Product $product)
    {
        if ($product) {
            $existingOrder = Order::where('user_id', auth()->id())
                ->where('status', 'Pending')
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingOrder) {
                return redirect('/request-order')->with('error', 'You already have a pending request. Please wait for the approval');
            }

            $total = $product->price;
            Order::create([
                'product_id'       => $request->product_id,
                'status'           => "Pending",
                'total_price'      => $total,
                'user_id'          => auth()->id()
            ]);
            $productName = $product->name;

            $log_entry = Auth::user()->name . " has requested an order: " . $productName . " with the id# " . $product->id;
            event(new UserLog($log_entry));

            return redirect('/request-order')->with('message', 'You successfully requested an order');
        } else {
            return back()->with('error', 'Product not found. Please try again.');
        }
    }

    public function cancelled(Order $order)
    {
        $product = $order->product;

        $order->delete();
        $productName = $product->name;

        $log_entry = Auth::user()->name . " has cancelled order: " . $productName . " with the id# " . $order->id;
        event(new UserLog($log_entry));

        return redirect('/request-order')->with('message', 'Order cancelled successfully');
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;

        $products = Product::where('name', 'like', "%$search%")
            ->orWhere('price', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orWhereHas('category', function ($categoryQuery) use ($search) {
                $categoryQuery->where('name', 'like', "%$search%");
            })
            ->get();

        return view('normal-view.pages.searched', compact('search', 'products'));
    }
}
