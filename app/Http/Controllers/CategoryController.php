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

    public function userIndex(){
        $categories = Category::with('products')->get();
        return view('home.categories',compact('categories'));
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
