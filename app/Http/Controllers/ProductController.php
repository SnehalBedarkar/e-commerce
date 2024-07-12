<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\fileExists;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('products.index-products', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        // Get all data from the request
        $data = $request->all();

        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|alpha_num|unique:products,sku|max:50',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ];

        // Validate the input data
        $validator = Validator::make($data, $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create a new Product instance
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock_quantity = $request->stock_quantity;
        $product->sku = $request->sku;
        $product->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $path = $image->store('images', 'public');
            $product->image = $path;
        }
        $product->save();
        return redirect()->route('products.index')->with('status', 'Product created successfully.');
    }

    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['success' => true, 'product' => $product]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
    }



    public function edit($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            $categories = Category::all();

            return response()->json([
                'success' => true,
                'product' => $product,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(string $id, Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'string|nullable',
            'stock_quantity' => 'required|numeric',
            'sku' => 'required|string|alph_num|unique:products,sku' . $id,
            'image' => 'image|max:2048'
        ];

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock_quantity = $request->stock_quantity;
        $product->sku = $request->sku;
        if ($request->hasFile('image')) {
            $imagePath = public_path('storage/' . $product->image);
            if (fileExists($imagePath)) {
                @unlink($imagePath);
            }
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $product->image = $path;
        }
        $product->save();
        return redirect()->route('products.index')->with('status', 'product updated successfully');
    }

    public function destroy(string $id)
    {
        try {
            // Find the product by ID or throw a ModelNotFoundException
            $product = Product::findOrFail($id);

            // Delete the associated image file if it exists
            $imagePath = public_path('storage/' . $product->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath); // Attempt to delete the file, ignoring errors
            }

            // Delete the product from the database
            $product->delete();

            // Return JSON response for AJAX requests
            return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where product with $id is not found
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions or errors
            return response()->json(['success' => false, 'message' => 'Error deleting product.'], 500);
        }
    }
}
