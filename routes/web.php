<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;


Route::get('/', [HomeController::class, 'index'])->name('home');







Route::get('/auth/login/form', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::get('/auth/register/form', [AuthController::class, 'showRegistraitionForm'])->name('auth.register.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');




Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');




Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/categories/{id}/products', [ProductController::class, 'productsByCategory'])->name('products.by.category');






Route::get('/categories/index/', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category/{id}/products', [HomeController::class,])->name('category.products');


Route::get('/users/index', [UserController::class, 'index'])->name('user.index');
Route::get('/user/show/{id}', [UserController::class, 'show'])->name(('user.show'));
Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/active/users', [UserController::class, 'activeUsers'])->name('users.active');


Route::get('/adminPage', [AdminController::class, 'adminPage'])->name('admin.dashboard');
Route::get('/users',[AdminController::class, 'usersList'])->name('admin.users.list');


Route::get('/orders',[OrderController::class, 'index'])->name('orders.index');
Route::post('/order/add/{id}',[OrderController::class, 'create'])->name('order.add');