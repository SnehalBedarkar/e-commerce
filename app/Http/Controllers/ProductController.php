<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\fileExists;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('Dashboard.products',compact('products','categories')); 
    }

    public function productsByCategory(int $id)
    {
        // Fetch products based on the provided category ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        // Assuming Category has a 'products' relationship
        $products = $category->products;

        return response()->json([
            'success' => true,
            'category' => $category,
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'name' => 'required|string|max:20',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|integer',
                'image' => 'nullable|image|max:2048',
            ];

            // Validate input data
            $validator = Validator::make($request->all(), $rules);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); // Unprocessable Entity status code
            }

            // Create a new Product instance
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->stock_quantity = $request->stock_quantity;
            $product->category_id = $request->category_id;

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $image = $request->image;
                $path = $image->store('images', 'public');
                $product->image = $path;
            }

            // Save the product
            $product->save();

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'data' => $product, // Optionally, you can return the saved product data
                'imagePath' => $path
            ], 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error is storing product ' . $e->getMessage());
            // Return a JSON response indicating failure
            return response()->json([
                'success' => false,
                'message' => 'Failed to store product. Please try again later.',
                'error' => $e->getMessage() // Optionally, include the detailed error message
            ], 500); // Internal Server Error status code
        }
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
        // Validation rules
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|numeric',
            'category_id' => 'required|integer',
            'image' => 'image|max:2048'
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400); // Bad Request status code
        }

        try {
            // Find the product or throw an exception if not found
            $product = Product::findOrFail($id);

            // Update product attributes
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->stock_quantity = $request->stock_quantity;
            $product->category_id = $request->category_id;
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                $imagePath = public_path('storage/' . $product->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }

                // Store the new image
                $image = $request->file('image');
                $path = $image->store('images', 'public');
                $product->image = $path;
            }

            // Save the product changes
            $product->save();

            // Return success response with updated product data
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json([
                'status' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500); // Internal Server Error status code
        }
    }


    public function destroy(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Retrieve the product ID from the request
        $productId = $request->input('product_id');

        // Find the product by its ID
        $product = Product::find($productId);

        if ($product) {
            // Construct the path to the image
            $imagePath = public_path('storage/' . $product->image);

            // Check if the image exists and delete it
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }

            // Delete the product
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }
    }

   public function multipleDelete(Request $request)
   {
        $data = $request->all();

        $rules = [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:products,id',
        ];
        $ids =  $data['ids'];

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'user ids are not valid'
            ]);
        }

        $products = Product::whereIn('id',$ids)->get();
        if(!$products){
            return response()->json([
                'success' => false,
                'message' => "no products founds",
            ]);
        }

        foreach($products as $product){
            $imagePath = public_path('storage/'.$product->image);
            if(file_exists($imagePath)){
                @unlink($imagePath);
            }
            $product->delete();
        }

        $remainingProductCount = Product::count();

        return response()->json([
            'success' => true,
            'message' => 'products deleted successfully',
            'remaining_products' => $remainingProductCount
        ]);
   }
}
