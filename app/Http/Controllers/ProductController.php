<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\fileExists;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


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

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|string|max:25',                  // Ensure name is required, a string, and no longer than 25 characters
            'price' => 'required|numeric|min:0',                 // Ensure price is required, numeric, and non-negative
            'description' => 'required|string|max:255',          // Ensure description is required, a string, and no longer than 255 characters
            'stock_quantity' => 'required|integer|min:0',        // Ensure stock_quantity is required, an integer, and non-negative
            'category_id' => 'required|integer|exists:categories,id', // Ensure category_id is required, an integer, and exists in the categories table
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is required, of a valid image type, and no larger than 2MB
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422); // Return 422 Unprocessable Entity status code for validation errors
        }

        $product = new Product();
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->stock_quantity = $data['stock_quantity'];
        $product->category_id = $data['category_id'];

        $imageUrl = null;
        // Storing the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $imageUrl =  Storage::url($path);
            $product->image = $path;
        }

        $product->save();

        $productCount = Product::count();

        return response()->json([
            'success' => true, // Set success to true
            'message' => 'Product added successfully',
            'data' => $product,
            'image_url' => $imageUrl,
            'product_count' => $productCount
        ], 200); // Return 200 OK status code for success
    }

    public function edit(Request $request){
        $data = $request->all();

        $rules = [
            'product_id' => 'required|integer'
        ];

        $validator = Validator::make($data,$rules);

        if($validator){
            return response()->json([
                'success' => false,
                'product' => $product,
            ]);
        }

        $product_id = $data['product_id'];

        $product = Product::where('id',$product_id);

        if($product){
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
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

   public function search(Request $request)
    {
        $data = $request->all();

        $rules = [
            'query' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ];
        
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422); // Return 422 Unprocessable Entity status code for validation errors
        }

        $query = $data['query'] ?? null;
        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;

        $productsQuery = Product::query();

        if ($query) {
            $searchableFields = [ 'id' ,'name', 'price', 'description', 'stock_quantity'];
            $productsQuery->where(function($q) use ($searchableFields, $query) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%$query%");
                }
            });
        }

        if ($start_date || $end_date) {
            if ($start_date && $end_date) {
                $productsQuery->whereBetween('created_at', [$start_date, $end_date]);
            } elseif ($start_date) {
                $productsQuery->where('created_at', '>=', $start_date);
            } elseif ($end_date) {
                $productsQuery->where('created_at', '<=', $end_date);
            }
        }

        $products = $productsQuery->get();

        if ($products->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No products found'
            ]);
        }
    }

    public function show(Request $request)
    {
        $data = $request->all();

        $rules = [
            'product_id' => 'required|integer'
        ];

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'message' => 'key is not valid',
                'success' => false,
            ]);
        }

        $product_id = $data['product_id'];

        $product = Product::where('id',$product_id)->get();

        if($product){
            return response()->json([
                'success' => true,
                'message' => 'product fetch successfully',
                'product' => $product
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'product not found'
            ]);
        }
    }

}
