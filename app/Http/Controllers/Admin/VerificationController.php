<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Notifications\ProductApprovedNotification;
use App\Notifications\ProductRejectedNotification;

class VerificationController extends Controller
{
    public function usersIndex(Request $request)
    {
        // Get filter parameters
        $sellerSearch = $request->input('seller_search');
        $sellerStatus = $request->input('seller_status');
        $buyerSearch = $request->input('buyer_search');
        $buyerStatus = $request->input('buyer_status');
        
        // Build seller query with filters
        $sellersQuery = User::where('role', 'seller')
            ->whereHas('profile', function ($query) {
                $query->whereNotNull('verification_doc');
            })
            ->with('profile');
            
        // Apply seller search filter
        if ($sellerSearch) {
            $sellersQuery->where(function($query) use ($sellerSearch) {
                $query->where('name', 'LIKE', "%{$sellerSearch}%")
                      ->orWhere('email', 'LIKE', "%{$sellerSearch}%");
            });
        }
        
        // Apply seller status filter
        if ($sellerStatus === 'verified') {
            $sellersQuery->whereHas('profile', function ($query) {
                $query->where('verified_by_admin', true);
            });
        } elseif ($sellerStatus === 'pending') {
            $sellersQuery->whereHas('profile', function ($query) {
                $query->where('verified_by_admin', false);
            });
        }
        
        // Get sellers with uploaded documents
        $sellersWithDocuments = $sellersQuery->paginate(10, ['*'], 'sellers_page');
        
        // Build buyer query with filters
        $buyersQuery = User::where('role', 'buyer');
        
        // Apply buyer search filter
        if ($buyerSearch) {
            $buyersQuery->where(function($query) use ($buyerSearch) {
                $query->where('name', 'LIKE', "%{$buyerSearch}%")
                      ->orWhere('email', 'LIKE', "%{$buyerSearch}%");
            });
        }
        
        // Apply buyer status filter
        if ($buyerStatus === 'approved') {
            $buyersQuery->where('is_verified', true);
        } elseif ($buyerStatus === 'pending') {
            $buyersQuery->where('is_verified', false);
        }
        
        // Get buyers
        $buyers = $buyersQuery->paginate(10, ['*'], 'buyers_page');
        
        return view('admin.verifications.users', compact('sellersWithDocuments', 'buyers'));
    }
    
    public function showSellerDetails(User $user)
    {
        // Verify that user is a seller
        if ($user->role !== 'seller') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        // Load the user with their profile
        $user->load('profile');
        
        // Check if user has a profile with document
        if (!$user->profile || is_null($user->profile->verification_doc)) {
            return redirect()->back()->with('error', 'No document found for this seller.');
        }
        
        return view('admin.verifications.seller-details', compact('user'));
    }
    
    public function showBuyerDetails(User $user)
    {
        // Verify that user is a buyer
        if ($user->role !== 'buyer') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        return view('admin.verifications.buyer-details', compact('user'));
    }
    
    /**
     * Serve the seller verification document directly
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function serveSellerDocument(User $user)
    {
        // Verify that user is a seller
        if ($user->role !== 'seller') {
            abort(404);
        }
        
        // Load the user with their profile
        $user->load('profile');
        
        // Check if user has a profile with document
        if (!$user->profile || is_null($user->profile->verification_doc)) {
            abort(404);
        }
        
        // Check if file exists
        if (!\Storage::disk('public')->exists($user->profile->verification_doc)) {
            abort(404);
        }
        
        // Return the file response
        return \Storage::disk('public')->response($user->profile->verification_doc);
    }
    
    public function productsIndex(Request $request)
    {
        // Get filter parameters
        $search = $request->input('search');
        $category = $request->input('category');
        $seller = $request->input('seller');
        $verificationStatus = $request->input('verification_status');
        
        // Build product query with filters
        $productsQuery = Product::with('seller', 'category', 'primaryImage')
            ->where('verification_status', 'pending'); // Only show pending products by default
        
        // Apply search filter
        if ($search) {
            $productsQuery->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        // Apply category filter
        if ($category) {
            $productsQuery->where('category_id', $category);
        }
        
        // Apply seller filter
        if ($seller) {
            $productsQuery->where('seller_id', $seller);
        }
        
        // Apply verification status filter
        if ($verificationStatus) {
            $productsQuery->where('verification_status', $verificationStatus);
        }
        
        // Get products pending verification
        $productsPendingVerification = $productsQuery->paginate(10, ['*'], 'products_page');
        
        // Get additional data for filters
        $categories = \App\Models\Category::all();
        $sellers = \App\Models\User::where('role', 'seller')->get();
        $verificationStatuses = ['pending', 'approved', 'rejected'];
        
        return view('admin.verifications.products', compact('productsPendingVerification', 'categories', 'sellers', 'verificationStatuses'));
    }
    
    public function showProductDetails(Product $product)
    {
        // Load the product with its relationships
        $product->load('seller', 'category', 'images'); // Load all images for detail view
        
        return view('admin.verifications.product-details', compact('product'));
    }
    
    public function verifySellerDocument(User $user)
    {
        // Verify that user is a seller
        if ($user->role !== 'seller') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        // Verify that user has a profile with document
        if (!$user->profile || is_null($user->profile->verification_doc)) {
            return redirect()->back()->with('error', 'No document found for this seller.');
        }
        
        // Update verification status for both admin verification and general verification
        $user->profile->update([
            'verified_by_admin' => true,
        ]);
        
        // Also set is_verified to true for general platform verification
        $user->update([
            'is_verified' => true,
        ]);
        
        return redirect()->route('admin.verifications.users.index')->with('success', 'Seller document verified successfully. The seller can now access all seller features.');
    }
    
    public function rejectSellerDocument(User $user)
    {
        // Verify that user is a seller
        if ($user->role !== 'seller') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        // Verify that user has a profile with document
        if (!$user->profile || is_null($user->profile->verification_doc)) {
            return redirect()->back()->with('error', 'No document found for this seller.');
        }
        
        // Delete the document file
        if ($user->profile->verification_doc) {
            \Storage::disk('public')->delete($user->profile->verification_doc);
        }
        
        // Update verification status
        $user->profile->update([
            'verification_doc' => null,
            'verified_by_admin' => false,
        ]);
        
        // Also set is_verified to false for general platform verification
        $user->update([
            'is_verified' => false,
        ]);
        
        return redirect()->route('admin.verifications.users.index')->with('success', 'Seller document rejected and deleted. The seller will need to upload a new document for verification.');
    }
    
    public function approveBuyer(User $user)
    {
        // Verify that user is a buyer
        if ($user->role !== 'buyer') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        // Update verification status
        $user->update([
            'is_verified' => true,
        ]);
        
        return redirect()->route('admin.verifications.users.index')->with('success', 'Buyer approved successfully. The buyer can now message sellers and request quotes.');
    }
    
    public function rejectBuyer(User $user)
    {
        // Verify that user is a buyer
        if ($user->role !== 'buyer') {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
        
        // Update verification status
        $user->update([
            'is_verified' => false,
        ]);
        
        return redirect()->route('admin.verifications.users.index')->with('success', 'Buyer rejected. The buyer will not be able to message sellers or request quotes.');
    }
    
    public function approveProduct(Product $product)
    {
        // Update verification status and set product to active
        $product->update([
            'verification_status' => 'approved',
            'status' => 'active' // Automatically set status to active when approved
        ]);
        
        // Send notification to the seller
        $product->seller->notify(new ProductApprovedNotification($product));
        
        return redirect()->route('admin.verifications.products.index')->with('success', 'Product approved successfully. The product is now visible to buyers.');
    }
    
    public function rejectProduct(Request $request, Product $product)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);
        
        // Update verification status and rejection reason
        $product->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        
        // Send notification to the seller
        $product->seller->notify(new ProductRejectedNotification($product, $request->rejection_reason));
        
        return redirect()->route('admin.verifications.products.index')->with('success', 'Product rejected. The product will not be visible to buyers.');
    }
}