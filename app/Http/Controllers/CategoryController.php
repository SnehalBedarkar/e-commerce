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
        $categories = Category::with('products')->get();
        return view('categories.index-categories', compact('categories'));
    }

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
            return redirect()->route('categories.index')->with('status', 'Category created successfully');
        } else {
            return back()->with('error', 'Failed to create category')->withInput();
        }
    }
}
