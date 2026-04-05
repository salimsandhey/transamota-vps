<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageService;

class ProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    public function store(StoreProductRequest $request)
    {
        // Prevent duplicate submissions using session
        $sessionId = 'product_submission_' . auth()->id();
        $lastSubmission = session($sessionId);
        
        // Log session data for debugging
        \Log::info('Session check for duplicate submission', [
            'session_id' => $sessionId,
            'last_submission' => $lastSubmission,
            'current_time' => time(),
            'time_diff' => $lastSubmission ? time() - $lastSubmission : null
        ]);
        
        // If last submission was less than 5 seconds ago, reject
        if ($lastSubmission && (time() - $lastSubmission) < 5) {
            \Log::warning('Duplicate submission detected and blocked', [
                'session_id' => $sessionId,
                'time_diff' => time() - $lastSubmission
            ]);
            return redirect()->back()->with('error', 'Please wait before submitting again.')->withInput();
        }
        
        // Store the timestamp of this submission
        session([$sessionId => time()]);
        \Log::info('Session timestamp stored', ['session_id' => $sessionId, 'timestamp' => time()]);
        
        try {
            // Log the request data for debugging
            \Log::info('Product store request received', [
                'has_images' => $request->hasFile('images'),
                'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
                'primary_image_id' => $request->primary_image_id,
                'all_files' => $request->allFiles(),
                'all_input' => $request->except('images')
            ]);

            $product = new Product();
            $product->seller_id = auth()->id();
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name) . '-' . time();
            $product->description = $request->description;
            $product->price = $request->price;
            $product->moq = $request->moq;
            $product->unit = $request->unit;
            $product->origin_country = $request->origin_country;
            // Set initial status for seller visibility control
            $product->status = 'inactive';
            // Set initial verification status for admin approval
            $product->verification_status = 'pending';
            $product->save();

            \Log::info('Product created', ['product_id' => $product->id]);

            // Handle image uploads (limit to 5 images)
            if ($request->hasFile('images')) {
                $images = array_slice($request->file('images'), 0, 5); // Limit to 5 images
                \Log::info('Processing images', ['count' => count($images)]);
                
                $primaryImageIndex = $request->primary_image_id !== null && $request->primary_image_id !== '' ? (int)$request->primary_image_id : 0;
                \Log::info('Primary image index', ['index' => $primaryImageIndex]);
                
                foreach ($images as $index => $image) {
                    \Log::info('Processing image', [
                        'index' => $index,
                        'original_name' => $image->getClientOriginalName(),
                        'size' => $image->getSize(),
                        'is_valid' => $image->isValid()
                    ]);
                    
                    try {
                        $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $image->extension();
                        // Store in the public disk
                        $path = $image->storeAs('products', $imageName, 'public');
                        \Log::info('Image stored', ['path' => $path]);
                        
                        // Compress and optimize the image immediately
                        $fullPath = storage_path('app/public/' . $path);
                        try {
                            $compressedPath = $this->imageService->processImage($fullPath, true, 1200, 1200, 80);
                            
                            // Update path if converted to WebP
                            if ($compressedPath !== $fullPath) {
                                // Extract just the relative path part for storage in database
                                $path = str_replace(storage_path('app/public/'), '', $compressedPath);
                            }
                        } catch (\Exception $e) {
                            \Log::error('Image compression failed: ' . $e->getMessage());
                            // Continue with original image if compression fails
                        }
                        
                        $productImage = new ProductImage();
                        $productImage->product_id = $product->id;
                        $productImage->image_path = $path; // This will be 'products/image_name.ext'
                        
                        // Set as primary if it matches the selected primary image index
                        $productImage->is_primary = ($index == $primaryImageIndex) ? true : false;
                        $productImage->save();
                        
                        \Log::info('Product image saved', [
                            'image_id' => $productImage->id,
                            'is_primary' => $productImage->is_primary
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Error saving product image', [
                            'error' => $e->getMessage(),
                            'index' => $index,
                            'product_id' => $product->id
                        ]);
                    }
                }
            } else {
                \Log::info('No images found in request');
            }

            // Clear the session lock on successful submission
            session()->forget($sessionId);

            return redirect()->route('seller.products')->with('success', 'Product created successfully and is pending admin verification.');
        } catch (\Exception $e) {
            // Clear the session lock on error so user can retry
            session()->forget($sessionId);
            
            \Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.')->withInput();
        }
    }

    public function index()
    {
        $products = Product::where('seller_id', auth()->id())->with('primaryImage')->get();
        return view('seller.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->with('images', 'category', 'subcategory')->firstOrFail();
        return view('seller.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->with('images')->firstOrFail();
        
        // Allow editing only for approved products, not for pending or rejected products
        if ($product->verification_status !== 'approved') {
            return redirect()->route('seller.products')->with('error', 'This product is not yet approved and cannot be edited. Please wait for admin approval.');
        }
        
        $categories = Category::all();
        
        // Get subcategories for the product's current category
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        
        // Use the correct view name
        return view('seller.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        // Prevent duplicate submissions using session
        $sessionId = 'product_update_' . auth()->id() . '_' . $id;
        $lastSubmission = session($sessionId);
        
        // Log session data for debugging
        \Log::info('Session check for duplicate update submission', [
            'session_id' => $sessionId,
            'last_submission' => $lastSubmission,
            'current_time' => time(),
            'time_diff' => $lastSubmission ? time() - $lastSubmission : null
        ]);
        
        // If last submission was less than 5 seconds ago, reject
        if ($lastSubmission && (time() - $lastSubmission) < 5) {
            \Log::warning('Duplicate update submission detected and blocked', [
                'session_id' => $sessionId,
                'time_diff' => time() - $lastSubmission
            ]);
            return redirect()->back()->with('error', 'Please wait before submitting again.')->withInput();
        }
        
        // Store the timestamp of this submission
        session([$sessionId => time()]);
        \Log::info('Update session timestamp stored', ['session_id' => $sessionId, 'timestamp' => time()]);
        
        try {
            \Log::info('Product update method called', [
                'product_id' => $id,
                'user_id' => auth()->id(),
                'request_method' => $request->method(),
                'has_files' => $request->hasFile('images'),
                'all_files' => $request->allFiles()
            ]);
            
            $product = Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
            
            // Allow updating only for approved products, not for pending or rejected products
            if ($product->verification_status !== 'approved') {
                return redirect()->route('seller.products')->with('error', 'This product is not yet approved and cannot be updated. Please wait for admin approval.');
            }
            
            \Log::info('Validation passed for product update', ['product_id' => $product->id]);

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->moq = $request->moq;
            $product->unit = $request->unit;
            $product->origin_country = $request->origin_country;
            // Only allow sellers to change visibility status
            $product->status = $request->status;
            
            // Only update slug if name changed
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($request->name) . '-' . time();
            }
            
            // Reset verification status to pending when updating an approved product
            if ($product->verification_status === 'approved') {
                $product->verification_status = 'pending';
                $product->rejection_reason = null;
            }
            
            $product->save();

            // Handle image deletions
            $deletedImages = false;
            if ($request->has('delete_images') && !empty($request->delete_images)) {
                // Convert comma-separated string to array if needed
                $deleteImageIds = is_array($request->delete_images) ? $request->delete_images : explode(',', $request->delete_images);
                foreach ($deleteImageIds as $imageId) {
                    if (!empty($imageId)) {
                        $image = ProductImage::where('id', $imageId)->where('product_id', $product->id)->first();
                        if ($image) {
                            // Check if this is the primary image
                            $wasPrimary = $image->is_primary;
                            
                            // Delete the file from storage
                            \Storage::disk('public')->delete($image->image_path);
                            $image->delete();
                            
                            // Mark that we deleted images
                            $deletedImages = true;
                        }
                    }
                }
            }

            // Handle new image uploads (limit to maintain max 5 images)
            \Log::info('Checking for new images in update request', [
                'has_images' => $request->hasFile('images'),
                'product_id' => $product->id
            ]);
            
            if ($request->hasFile('images')) {
                // Calculate how many more images we can add (max 5 total)
                $currentImageCount = $product->images()->count();
                $remainingSlots = 5 - $currentImageCount;
                
                \Log::info('Image capacity check', [
                    'current_count' => $currentImageCount,
                    'remaining_slots' => $remainingSlots
                ]);
                
                if ($remainingSlots > 0) {
                    // Get all uploaded files, not just a slice
                    $images = $request->file('images');
                    // But limit to remaining slots
                    $images = is_array($images) ? array_slice($images, 0, $remainingSlots) : [$images];
                    
                    \Log::info('Processing new images', [
                        'image_count' => count($images),
                        'product_id' => $product->id
                    ]);
                    
                    // Get the primary image index for new images if specified
                    $primaryNewImageIndex = null;
                    if ($request->has('primary_new_image_index')) {
                        $primaryNewImageIndex = (int)$request->primary_new_image_index;
                    }
                    
                    foreach ($images as $index => $image) {
                        try {
                            \Log::info('Processing image', [
                                'index' => $index,
                                'original_name' => $image->getClientOriginalName(),
                                'size' => $image->getSize(),
                                'is_valid' => $image->isValid()
                            ]);
                            
                            $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $image->extension();
                            // Store in the public disk
                            $path = $image->storeAs('products', $imageName, 'public');
                            
                            // Compress and optimize the image immediately
                            $fullPath = storage_path('app/public/' . $path);
                            try {
                                $compressedPath = $this->imageService->processImage($fullPath, true, 1200, 1200, 80);
                                
                                // Update path if converted to WebP
                                if ($compressedPath !== $fullPath) {
                                    // Extract just the relative path part for storage in database
                                    $path = str_replace(storage_path('app/public/'), '', $compressedPath);
                                }
                            } catch (\Exception $e) {
                                \Log::error('Image compression failed: ' . $e->getMessage());
                                // Continue with original image if compression fails
                            }
                            
                            \Log::info('Image stored', [
                                'path' => $path,
                                'product_id' => $product->id
                            ]);
                            
                            $productImage = new ProductImage();
                            $productImage->product_id = $product->id;
                            $productImage->image_path = $path; // This will be 'products/image_name.ext'
                            
                            // Set as primary if it matches the selected primary new image index
                            $productImage->is_primary = ($index == $primaryNewImageIndex) ? true : false;
                            
                            $productImage->save();
                            
                            \Log::info('Product image saved to database', [
                                'image_id' => $productImage->id,
                                'product_id' => $product->id,
                                'is_primary' => $productImage->is_primary
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('Error saving product image during update', [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString(),
                                'product_id' => $product->id
                            ]);
                            return redirect()->back()->with('error', 'Error uploading image: ' . $e->getMessage())->withInput();
                        }
                    }
                } else {
                    \Log::info('No remaining slots for new images', [
                        'current_count' => $currentImageCount,
                        'product_id' => $product->id
                    ]);
                    return redirect()->back()->with('error', 'You have reached the maximum of 5 images for this product.')->withInput();
                }
            } else {
                \Log::info('No new images found in request', [
                    'product_id' => $product->id
                ]);
            }

            // Handle primary image logic after all operations
            $this->handlePrimaryImageLogic($product, $deletedImages, $request);

            // Clear the session lock on successful submission
            session()->forget($sessionId);

            // Add a special message when updating an approved product
            if ($product->wasChanged('verification_status')) {
                return redirect()->route('seller.products')->with('success', 'Product updated and sent back for admin verification.');
            } else {
                return redirect()->route('seller.products')->with('success', 'Product updated successfully.');
            }
        } catch (\Exception $e) {
            // Clear the session lock on error so user can retry
            session()->forget($sessionId);
            
            \Log::error('Error updating product', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $id
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while updating the product: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Handle primary image logic after image operations
     */
    private function handlePrimaryImageLogic($product, $deletedImages, $request)
    {
        // Refresh the product images relationship
        $product->load('images');
        
        // Get all images for this product
        $images = $product->images;
        
        // Case 1: Product has no images, nothing to do
        if ($images->count() == 0) {
            return;
        }
        
        // Case 2: Product has only one image, make it primary
        if ($images->count() == 1) {
            $image = $images->first();
            if (!$image->is_primary) {
                // Set all images to non-primary first
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                // Make the single image primary
                $image->is_primary = true;
                $image->save();
            }
            return;
        }
        
        // Case 3: Check if a specific primary image was selected in the form (existing image)
        if ($request->has('primary_image') && !empty($request->primary_image)) {
            // Set all images to non-primary first
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
            
            // Set the selected existing image as primary
            $primaryImage = ProductImage::where('id', $request->primary_image)->where('product_id', $product->id)->first();
            if ($primaryImage) {
                $primaryImage->is_primary = true;
                $primaryImage->save();
            }
        }
        // Case 4: Check if a specific primary new image was selected in the form
        elseif ($request->has('primary_new_image_index') && $request->primary_new_image_index !== null) {
            // Set all images to non-primary first
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
            
            // The primary new image will be set when saving new images, so we don't need to do anything here
            // The new images logic already handles this
        }
        // Case 5: Check if we deleted images and there's no primary image anymore
        elseif ($deletedImages) {
            $hasPrimaryImage = $images->contains('is_primary', true);
            if (!$hasPrimaryImage) {
                // Set all images to non-primary first
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                
                // Make the first image primary
                $firstImage = $images->first();
                if ($firstImage) {
                    $firstImage->is_primary = true;
                    $firstImage->save();
                }
            }
        }
        // Case 6: If no primary image exists for any other reason, set the first one as primary
        else {
            $hasPrimaryImage = $images->contains('is_primary', true);
            if (!$hasPrimaryImage) {
                // Set all images to non-primary first
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                
                // Make the first image primary
                $firstImage = $images->first();
                if ($firstImage) {
                    $firstImage->is_primary = true;
                    $firstImage->save();
                }
            }
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
        
        // Validate the status - only allow active/inactive for sellers
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        // Only allow sellers to change visibility status if product is verified
        if ($product->verification_status === 'approved') {
            $product->status = $request->status;
            $product->save();
            return response()->json(['success' => true, 'message' => 'Product visibility updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Product must be verified by admin before you can change its visibility.']);
        }
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
        
        // Check if product is verified before allowing deletion
        if ($product->verification_status !== 'approved') {
            return redirect()->route('seller.products')->with('error', 'This product is pending verification and cannot be deleted until approved by admin.');
        }
        
        // Delete all associated images from storage
        foreach ($product->images as $image) {
            // Delete the file from storage
            \Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the product (this will also delete associated images due to foreign key constraints)
        $product->delete();

        return redirect()->route('seller.products')->with('success', 'Product deleted successfully.');
    }
}