<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories',compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();


        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation failed',
                'success' => false,
            ],);
        }

        // Generate the slug
        $data['slug'] = Str::slug($request->name, '-');

        $category = new Category();
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = $image->store('images/categories','public');
            $category->image = $path;
        }

        $category->save();
        
        if($category){
            return response()->json([
                'message' => 'Category added successfully',
                'success' => true,
                'category' => $category
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $rules = [
            'category_id' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $categoryId = $data['category_id'];

        // Find the category by ID
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'success' => false,
            ]);
        }

        // Delete the category
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
            'success' => true,
            'category' => $category
        ]);
    }

    public function showCategory(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Category ID is not valid'
            ]);
        }
    
        // Fetch the category using the validated ID
        $category = Category::find($request->category_id);
    
        // Check if the category was found
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }
    
        // Return the category data
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }   
    
    public function categoryWiseProducts(string $id)
    {
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products;
        return view('home.products', compact('category', 'products'));
    }

}
