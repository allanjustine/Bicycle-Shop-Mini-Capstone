<?php

use App\Http\Controllers\NormalView\IndexController;
use App\Http\Controllers\NormalView\CartController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthIndexController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TestEnrollmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'productList'])->name('carts');
Route::get('/results/search', [IndexController::class, 'searchProduct'])->name('searched');

Route::get('/login', [AuthIndexController::class, 'loginPage'])->name('login');
Route::post('/', [AuthIndexController::class, 'login']);

Route::get('/register', [AuthIndexController::class, 'registerPage']);
Route::put('/register', [AuthIndexController::class, 'register'])->name('register');
Route::get('/verification/{user}/{token}', [AuthIndexController::class, 'verification']);

Route::get('/category/{category}', [IndexController::class, 'categoryList']);


Route::get('/logout', [AuthIndexController::class, 'logout']);

Route::middleware(['auth', 'verified'])->group(function () {

    //admin permission route
    Route::middleware('can:manage-all')->group(function () {
        Route::get('/admin/dashboard', [AdminIndexController::class, 'adminDashboard']);

        Route::get('/admin/users/result/search', [AdminPageController::class, 'search'])->name('admin.users.search');

        Route::get('/admin/users', [AdminPageController::class, 'userList']);
        Route::get('/admin/users/create', [AdminPageController::class, 'createUser']);
        Route::post('/admin/users/create', [AdminPageController::class, 'create'])->name('admin.user.create');
        Route::get('/admin/users/update/{user}', [AdminPageController::class, 'updateUser']);
        Route::put('/admin/users/update/{user}', [AdminPageController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/users/{user}', [AdminPageController::class, 'delete'])->name('admin.user.delete');

        Route::get('/admin/logs', [LogController::class, 'index'])->name('logs.index');

        Route::get('/admin/categories', [CategoryController::class, 'categories']);
        Route::get('/admin/categories/create', [CategoryController::class, 'createCategory']);
        Route::post('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::get('/admin/categories/update/{category}', [CategoryController::class, 'updateCategory']);
        Route::put('/admin/categories/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'delete'])->name('admin.category.delete');

        Route::get('/admin/products', [ProductController::class, 'index']);
        Route::get('/admin/products/create', [ProductController::class, 'createProduct']);
        Route::post('/admin/products/create', [ProductController::class, 'store'])->name('admin.products.create');
        Route::get('/admin/products/update/{product}', [ProductController::class, 'updateProduct']);
        Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'delete'])->name('admin.products.delete');
        Route::get('/admin/products/result/search', [ProductController::class, 'searchProduct'])->name('admin.products.search');

        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::get('/admin/orders/create', [OrderController::class, 'createOrder']);
        Route::put('/admin/orders/{order}', [OrderController::class, 'manageOrders'])->name('admin.ordres.confirm');
        Route::post('/admin/orders/create', [OrderController::class, 'createOrderNow'])->name('admin.orders.create');
        Route::get('/admin/orders/result/search', [OrderController::class, 'searchOrder'])->name('admin.orders.search');
    });

    //user permission route
    Route::middleware('can:customer')->group(function () {

        Route::get('/request-order', [IndexController::class, 'orders']);
        Route::post('/request-order/{product}', [IndexController::class, 'orderCreate'])->name('orders.create');
        Route::delete('/request-order/{order}', [IndexController::class, 'cancelled'])->name('order.cancel');
    });

    Route::get('/send-testenrollment', [TestEnrollmentController::class, 'sendTestNotification']);
});
Route::get('/sendmail', [EmailController::class, 'sendEmail']);
