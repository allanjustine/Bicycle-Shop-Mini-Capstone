<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function viewOrders(User $user)
    {
        return view('admin.orders.view', compact('user'));
    }

    public function manageOrders(Request $request, Order $order)
    {
        $statusUpdated = $request->status;

        // Validate the provided status against expected values
        $validStatuses = ['Pending', 'Paid', 'Confirmed'];
        if (!in_array($statusUpdated, $validStatuses)) {
            return back()->with('error', 'Invalid status provided');
        }

        // Check the current status and update accordingly
        if ($statusUpdated == "Pending") {
            $statusUpdated = "Confirmed";
        } elseif ($statusUpdated == "Confirmed") {
            $statusUpdated = "Paid";
        }

        // Update the order status
        $order->update([
            'status' => $statusUpdated,
        ]);

        $log_entry = Auth::user()->name . " marked as " . $statusUpdated . " for " .  $order->user->name . "'s order. " . " with the id# " . $order->id;
        event(new UserLog($log_entry));

        return back()->with('message', 'Order status updated successfully');
    }


    public function searchOrder(Request $request)
    {
        $search = $request->search;

        $users = User::has('orders')->withCount('orders')->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('gender', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.orders.searched', compact('users', 'search'));
    }

    public function createOrder()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();
        $categories = Category::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'categories', 'products'));
    }
    public function createOrderNow(Request $request)
    {
        $request->validate([
            'product_id'       => ['required'],
            'status'           => ['required'],
            'user_id'          => ['required']
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Product not found. Please try again.');
        }
        $user = User::find($request->user_id);
        $existingOrder = Order::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingOrder) {
            return redirect('/admin/orders')->with('error', 'This customer has already pending request.');
        }
        $total = $product->price;

        $order = Order::create([
            'product_id'       => $request->product_id,
            'status'           => $request->status,
            'total_price'      => $total,
            'user_id'          => $request->user_id
        ]);

        $productName = $product->name;

        $log_entry = Auth::user()->name . " has ordered: " . $productName . " for " . $order->user->name . " with the id# " . $order->id;
        event(new UserLog($log_entry));

        return redirect('/admin/orders')->with('message', 'Successfully added an order' . $productName . ' to '  . $order->user->name);
    }
}
