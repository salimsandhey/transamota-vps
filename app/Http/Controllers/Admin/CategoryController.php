<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Debug: Log detailed request information
        \Log::info('Category search request START:', [
            'search_param' => $search,
            'all_params' => $request->all(),
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl()
        ]);
        
        $query = Category::withCount('products');
        
        if ($search) {
            \Log::info('Applying search filter:', ['search_term' => $search]);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        } else {
            \Log::info('NO search condition applied - returning all categories');
        }
        
        $categories = $query->paginate(10);
        
        // Debug: Log the SQL query and results
        \Log::info('Category query SQL:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        \Log::info('Category results END:', [
            'count' => $categories->count(), 
            'total' => $categories->total(),
            'class' => get_class($categories)
        ]);
        
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:500',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        Category::create($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:500',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    
    public function destroy(Category $category)
    {
        // Check if category has products or subcategories
        if ($category->products()->count() > 0 || $category->subcategories()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with associated products or subcategories.');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
    
    public function showProducts(Category $category)
    {
        $products = $category->products()->with('seller', 'subcategory')->paginate(10);
        return view('admin.categories.products', compact('category', 'products'));
    }
    
    // Subcategory methods
    public function subcategories(Category $category)
    {
        $subcategories = $category->subcategories()->paginate(10);
        return view('admin.categories.subcategories.index', compact('category', 'subcategories'));
    }
    
    public function createSubcategory(Category $category)
    {
        return view('admin.categories.subcategories.create', compact('category'));
    }
    
    public function storeSubcategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:subcategories,category_id,' . $category->id,
            'description' => 'nullable|string',
        ]);
        
        $validated['category_id'] = $category->id;
        $validated['slug'] = Str::slug($validated['name']);
        
        Subcategory::create($validated);
        
        return redirect()->route('admin.categories.subcategories.index', $category)->with('success', 'Subcategory created successfully.');
    }
    
    public function editSubcategory(Category $category, Subcategory $subcategory)
    {
        return view('admin.categories.subcategories.edit', compact('category', 'subcategory'));
    }
    
    public function updateSubcategory(Request $request, Category $category, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:subcategories,name,' . $subcategory->id . ',id,category_id,' . $category->id,
            'description' => 'nullable|string',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        $subcategory->update($validated);
        
        return redirect()->route('admin.categories.subcategories.index', $category)->with('success', 'Subcategory updated successfully.');
    }
    
    public function destroySubcategory(Category $category, Subcategory $subcategory)
    {
        // Check if subcategory has products
        if ($subcategory->products()->count() > 0) {
            return redirect()->route('admin.categories.subcategories.index', $category)->with('error', 'Cannot delete subcategory with associated products.');
        }
        
        $subcategory->delete();
        
        return redirect()->route('admin.categories.subcategories.index', $category)->with('success', 'Subcategory deleted successfully.');
    }
    
    public function showSubcategoryProducts(Category $category, Subcategory $subcategory)
    {
        $products = $subcategory->products()->with('seller')->paginate(10);
        return view('admin.categories.subcategories.products', compact('category', 'subcategory', 'products'));
    }
}