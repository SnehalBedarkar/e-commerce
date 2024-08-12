<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;

use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthUser;


// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/list',[HomeController::class, 'productList'])->name('products.list');




// Authorisation Routes

Route::any('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/forgot-password-form',[AuthController::class, 'showForgotPassword'])->name('auth.forgot.password.form');
Route::post('/auth/forgot-password',[AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
Route::post('/auth/verify-otp',[AuthController::class, 'verifyOtp'])->name('auth.verify.otp');
Route::get('/auth/register-new-password-form',[AuthController::class, 'passwordResetForm'])->name('auth.register.password.form');
Route::post('/auth/register-new-password',[AuthController::class, 'resetPassword'])->name('auth.reset.password');



Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index')->middleware(AuthUser::class);
Route::put('/cart/update',[CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/placeOrder',[CartController::class, 'placeOrder'])->name('cart.place.order');

// Prouducts Routes
Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::delete('/prouducts/multiple-delete',[ProductController::class, 'multipleDelete'])->name('products.multiple.delete');
Route::get('/categories/{id}/products', [ProductController::class, 'productsByCategory'])->name('products.by.category');

// Category Routes 
Route::get('/categories/index/', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/user',[CategoryController::class, 'userIndex'])->name('categories.user');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category/{id}/products', [HomeController::class,])->name('category.products');

// Users Routes
Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
Route::get('/users/search',[UserController::class, 'usersSearch'])->name('users.search');
Route::get('/users/chart',[UserController::class, 'chartData'])->name('users.chart');
Route::get('/user/show/{id}', [UserController::class, 'show'])->name(('user.show'));
Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/users/multiple-delete',[UserController::class, 'multipleDelete'])->name('users.multiple.delete');
Route::get('/active/users', [UserController::class, 'activeUsers'])->name('users.active');

// Admin Routes
Route::get('/adminPage', [AdminController::class, 'adminPage'])->name('admin.dashboard')->middleware('auth');
Route::get('/active/users',[AdminController::class, 'activeUsers'])->name('active.users');
Route::get('/users',[AdminController::class, 'usersList'])->name('admin.users.list');

// Orders Routes
Route::get('/orders',[OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/chart',[OrderController::class, 'chartData'])->name('orders.chart');
Route::post('/order/add',[OrderController::class, 'addOrder'])->name('order.add');
Route::get('/users/orders',[OrderController::class, 'userSpecificOrders'])->name('user.orders');
Route::get('/orders/status',[OrderController::class, 'ordersStatus'])->name('orders.status');
Route::get('/order/placed',[OrderController::class, 'orderPlaced'])->name('order.placed');
Route::delete('/order/delete',[OrderController::class, 'orderDestroy'])->name('order.destroy');

Route::get('/checkout',[CheckoutController::class, 'showCheckout'])->name('checkout');
Route::put('/checkout/update',[CheckoutController::class, 'checkoutUpdate'])->name('checkout.update');


Route::get('/wishlist',[WishlistController::class, 'userSpecificWishlist'])->name('wishlist.user');


Route::post('/payment',[PaymentController::class, 'payment'])->name('payment');



