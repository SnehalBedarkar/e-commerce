<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::all();
        $categories = Category::all();
        return view('Dashboard.brands' ,compact('brands','categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();


        // Validation rules
        $rules = [
            'name' => 'required|string|max:25',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        $data['slug'] = Str::slug($request->name, '-');

        // Create a new brand
        $brand = new Brand();
        $brand->name = $data['name'];
        $brand->slug = $data['slug'];
        $brand->description = $data['description'];
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('logos', 'public');
            $brand->logo = $logoPath;
        }

        // Save the brand to the database
        $brand->save();

        return response()->json([
            'message' => 'Brand created successfully',
            'success' => true,
            'brand' => $brand
        ]);
    }

    public function show(Request $request)
    {
        $data = $request->all();
        $rules = [
            'product_id' => 'required|integer',
        ];

        $validator = Validator::make($data,$rules);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'messege' => 'Validation Failed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $brandId = $data['brand_id'];

        $brand = Brand::where('id',$brandId);
        if($brand){
            return response()->json([
                'success' => true,
                'brand' => $brand
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Brand Found',
            ]);
        }
    }
}
