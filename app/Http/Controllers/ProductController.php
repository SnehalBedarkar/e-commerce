<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
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
        $brands = Brand::all();
        return view('Dashboard.products',compact('products','categories','brands'));
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

        if($validator->fails()){
            return response()->json([
                'success' => false,
            ]);
        }

        $product_id = $data['product_id'];

        $product = Product::where('id',$product_id)->get();

        if($product){
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }

    }

    public function update(Request $request)
    {
        // Retrieve all the data from the request
        $data = $request->all();

        // Define validation rules
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|numeric',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|max:2048' // image is optional
        ];

        // Validate the request
        $validator = Validator::make($data, $rules);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400); // Bad Request status code
        }

        // Find the product by ID
        $product_id = $data['id'];
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404); // Not Found status code
        }

        // Update product attributes
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->stock_quantity = $data['stock_quantity'];
        $product->category_id = $data['category_id'];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $imageUrl = Storage::url($path);

            // Delete the old image if it exists and is different from the new one
            if ($product->image && $product->image !== $path) {
                // Extract the old image path from the stored path
                $oldImagePath = 'public/images/' . basename($product->image);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            // Update the product with the new image path
            $product->image = $path;
        }

        // Save the product or perform other actions
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200); // OK status code
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


    public function showProduct(Request $request, String $id)
    {
        $product = Product::findOrFail($id);
        return view('home.product_details', compact('product'));
    }


    public function viewsOnProduct(Request $request)
    {
        $data = $request->all();
        $rules = [
            'product_id' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        $productId = $data['product_id'];

        // Check if the product exists
        $product = Product::findOrFail($productId);

        // Increment the views count
        $product->view_count = $product->views + 1;
        $product->save();

        return response()->json([
            'message' => 'Product views updated successfully',
            'success' => true,
            'views' => $product->views
        ]);
    }

    public function sort(Request $request)
    {
        // Validate inputs
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'sort' => 'nullable|string|in:low_to_high,high_to_low,popularity,newest'
        ]);

        $categoryId = $request->input('category_id');
        $sortType = $request->input('sort');

        $query = Product::where('category_id', $categoryId);

        switch ($sortType) {
            case 'low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'popularity':
                $query->orderBy('popularity', 'desc'); // Assuming you have a 'popularity' column
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                // Optional: You could add a default sort, e.g., by name or relevance
                $query->orderBy('name', 'asc');
                break;
        }

        $products = $query->get();


        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }


}
