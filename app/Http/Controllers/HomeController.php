<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->orderBy('view_count', 'desc')->take(4); // Adjust as needed
        }])->get();

        $electronicsProducts = Product::where('category_id',3)->get();

        return view('home.index', compact('categories','electronicsProducts'));
    }

    public function indexCategoryWise($id)
    {
        try {
            $category = Category::with('products')->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'category_id' => $category->id,
                'category_name' => $category->name,
                'products' => $category->products
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching category products: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching category products. Please check the logs for details.'
            ], 500);
        }
    }

    // public function productList(){
    //     $products = Product::all();
    //     $brands = Brand::all();
    //     return view('home.products',compact('products','brands'));
    // }


}
