<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'description'   => 'nullable',
        ]);

        $category = Category::create([
            'name'              =>      $request->name,
            'description'      =>       $request->description,

        ]);

        $log_entry = Auth::user()->name . " added a new category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        return redirect('admin/categories')->with('message', 'Category created successfully!');
    }

    public function updateCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
            'description' => 'nullable',
        ]);


        $imagePath = $category->cat_image;

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $log_entry = Auth::user()->name . " updated an category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        return redirect('admin/categories')->with('message', 'Category updated successfully.');
    }

    public function delete(Category $category)
    {

        $log_entry = Auth::user()->name . " deleted the category name: " . $category->name . " with the id# " . $category->id;
        event(new UserLog($log_entry));
        $category->delete();
        return redirect('admin/categories')->with('message', 'Category deleted successfully.');
    }
}
