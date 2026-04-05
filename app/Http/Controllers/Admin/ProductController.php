<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

class ProductController extends Controller
{
    /**
     * Display a listing of all products with filtering options
     */
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category', 'subcategory']);
        
        // Apply filters if provided
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('seller')) {
            $query->where('seller_id', $request->seller);
        }
        
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $products = $query->latest()->paginate(20);
        $categories = Category::all();
        $sellers = User::where('role', 'seller')->get();
        $verificationStatuses = ['pending', 'approved', 'rejected'];
        
        return view('admin.products.index', compact('products', 'categories', 'sellers', 'verificationStatuses'));
    }
    
    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['seller', 'category', 'subcategory', 'images']);
        return view('admin.products.show', compact('product'));
    }
    
    /**
     * Verify a product (approve) and automatically set status to active
     */
    public function verify(Product $product)
    {
        $product->update([
            'verification_status' => 'approved',
            'status' => 'active'
        ]);
        return redirect()->back()->with('success', 'Product verified successfully and set to active.');
    }
    
    /**
     * Reject a product verification
     */
    public function reject(Request $request, Product $product)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);
        
        $product->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        
        return redirect()->back()->with('success', 'Product verification rejected.');
    }
    
    /**
     * Handle bulk actions for products
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
            'action' => 'required|in:verify,reject,delete',
            'rejection_reason' => 'required_if:action,reject|string|max:1000'
        ]);
        
        $ids = $request->ids;
        
        switch ($request->action) {
            case 'verify':
                Product::whereIn('id', $ids)->update([
                    'verification_status' => 'approved',
                    'status' => 'active'
                ]);
                $message = 'Selected products verified successfully and set to active.';
                break;
                
            case 'reject':
                Product::whereIn('id', $ids)->update([
                    'verification_status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason
                ]);
                $message = 'Selected products rejected successfully.';
                break;
                
            case 'delete':
                // Delete associated images first
                $products = Product::whereIn('id', $ids)->get();
                foreach ($products as $product) {
                    foreach ($product->images as $image) {
                        \Storage::disk('public')->delete($image->image_path);
                    }
                }
                
                Product::whereIn('id', $ids)->delete();
                $message = 'Selected products deleted successfully.';
                break;
        }
        
        // Redirect back to the products index page with the success message
        return redirect()->route('admin.products.index')->with('success', $message);
    }
    
    /**
     * Edit the specified product
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }
    
    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'origin_country' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'verification_status' => 'required|in:pending,approved,rejected',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
    
    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        // Delete all associated images from storage
        foreach ($product->images as $image) {
            // Delete the file from storage
            \Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the product
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}