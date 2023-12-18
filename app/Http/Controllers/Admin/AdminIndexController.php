<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Log;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminIndexController extends Controller
{
    public function adminDashboard()
    {
        $categories = Category::all();
        $products = Product::all();
        $orders = Order::all();
        $users = User::all();
        $logs = Log::all();

        return view('admin.pages.dashboard', compact('categories', 'products', 'orders', 'users', 'logs'));
    }
}
