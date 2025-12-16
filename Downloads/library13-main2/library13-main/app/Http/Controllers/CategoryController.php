<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\CategoryResourse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    function index()
    {
        // $categories = Category::all();
        $categories = Category::withCount('books')->get();
        // $categories = Category::with('books')->get();
        // return $categories;

        return ResponseHelper::success("all category", CategoryResourse::collection($categories));
        
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return [
            'success' => true,
            'message' => "category added successfully",
            'data' => $category
        ];
    }

    function show($id)
    {
        $category = Category::find($id);
        return ResponseHelper::success("one category", new CategoryResourse( $category));
       
    }

    function update(Request $request, $id)
    {
        //except: pk of excepted record
        $request->validate([
            'name' => "required|max:50|unique:categories,name,$id"
        ]);
        // return $request;
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return [
            'success' => true,
            'message' => "category updated successfully",
            'data' => $category

        ];
    }
    function destroy($id)
    {
        $category = Category::find($id);
        if ($category->books->count())
            return [
                'success' => false,
                'message' => "can't delete category has books",
            ];

        $category->delete();
        return [
            'success' => true,
            'message' => "category deleted successfully"
        ];
    }
}
