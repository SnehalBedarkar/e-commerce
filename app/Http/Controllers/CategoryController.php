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
        return view('Dashboard.categories',compact('categories'));
    }

    // public function listOfCategories(){
    //     $categories = Category::all();
    //     return response()->json([
    //         'success' => true,
    //         'categories' => $categories
    //     ]);
    // }

    public function create()
    {
        return view('categories.create-category');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required|string',
            'description' => 'nullable|string'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Generate the slug
        $data['slug'] = Str::slug($request->name, '-');

        $category = Category::create($data);

        if ($category) {
            return response()->json([   
                'success' => true,
                'message' => 'category created successfully',
            ]);
        }
    }
}
