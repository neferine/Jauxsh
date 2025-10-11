<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);
        
        Category::create($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }
    
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }
    
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);
        
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }
    
    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}