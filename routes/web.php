<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return "test route work";
});

Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/categories/index', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');


Route::get('/users/index', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create/register', [UserController::class, 'showRegistraitionForm'])->name('user.create.register');
Route::post('/user/register', [UserController::class, 'processRegistraition'])->name('user.register');
Route::get('/user/create/login', [UserController::class, 'showLoginForm'])->name('user.create.login');
Route::post('/user/login', [UserController::class, 'processLogin'])->name('user.login');
Route::get('/user/show/{id}', [UserController::class, 'show'])->name(('user.show'));
Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');
