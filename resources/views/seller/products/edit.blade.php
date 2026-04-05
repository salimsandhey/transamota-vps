@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out md:ml-0">
            @include('layouts.nav.content-header', [
                'title' => 'Edit Product',
                'subtitle' => 'Update your product information',
                'headerActions' => '<a href="' . route('seller.products') . '" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>'
            ])

            <div class="p-8">
                <!-- Notification for approved products -->
                @if($product->verification_status == 'approved')
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Editing Approved Product</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>After making your changes, this product will be sent back for admin verification.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-4xl">
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414-1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 101.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Display error message -->
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="editProductForm" action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Product Images -->
                            <div class="lg:col-span-1">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Images</h3>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-600 mb-2">Drag and drop images here</p>
                                        <p class="text-sm text-gray-500 mb-4">or</p>
                                        <label class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 cursor-pointer">
                                            Browse Files
                                            <input type="file" id="imageUpload" name="images[]" multiple accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF, WEBP up to 2MB (Max 5 images total)</p>
                                    </div>
                                </div>
                                
                                <!-- Image Preview Container -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">New Image Preview</h3>
                                    <div id="imagePreviewContainer" class="space-y-4">
                                        <!-- Image previews will be added here dynamically -->
                                        <div class="text-center text-gray-500 py-8 hidden" id="noImagesMessage">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p>No new images selected</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Existing Images Preview -->
                                @if($product->images->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                                    @foreach($product->images as $image)
                                    <div class="relative group" data-image-id="{{ $image->id }}">
                                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}" alt="Product image" class="w-full h-24 object-cover rounded-lg {{ $image->is_primary ? 'border-2 border-blue-500' : '' }}">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                            <button type="button" class="text-white hover:text-red-500 delete-image-btn" data-image-id="{{ $image->id }}">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Primary Image Checkbox -->
                                        <div class="absolute bottom-1 right-1 bg-white bg-opacity-80 text-gray-800 text-xs px-2 py-1 rounded flex items-center">
                                            <input type="checkbox" name="primary_image" value="{{ $image->id }}" class="primary-image-checkbox mr-1" {{ $image->is_primary ? 'checked' : '' }}>
                                            <span>Primary</span>
                                        </div>
                                        <!-- Hidden radio button (kept for backward compatibility) -->
                                        <input type="radio" name="primary_image_radio" value="{{ $image->id }}" class="primary-image-radio hidden" {{ $image->is_primary ? 'checked' : '' }}>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Details</h3>
                                
                                <!-- Basic Information -->
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-4">Basic Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Origin Country *</label>
                                            <input type="text" name="origin_country" value="{{ old('origin_country', $product->origin_country) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                                        <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                                
                                <!-- Pricing & Inventory -->
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-4">Pricing & Inventory</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹)</label>
                                            <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Quantity *</label>
                                            <input type="number" name="moq" value="{{ old('moq', $product->moq) }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                            <select name="unit" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="piece" {{ old('unit', $product->unit) == 'piece' ? 'selected' : '' }}>Piece</option>
                                                <option value="set" {{ old('unit', $product->unit) == 'set' ? 'selected' : '' }}>Set</option>
                                                <option value="pair" {{ old('unit', $product->unit) == 'pair' ? 'selected' : '' }}>Pair</option>
                                                <option value="box" {{ old('unit', $product->unit) == 'box' ? 'selected' : '' }}>Box</option>
                                                <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Categories -->
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-4">Categories</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                            <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="">Select a category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                                            <select name="subcategory_id" id="subcategory_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select a subcategory</option>
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-4">Product Status</h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Visibility Status *</label>
                                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active (Visible to buyers)</option>
                                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive (Hidden from buyers)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden inputs for image management -->
                                <input type="hidden" name="delete_images" id="deleteImagesInput" value="">
                                
                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                                    <a href="{{ route('seller.products') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                                    <button type="submit" id="updateProductBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Category and subcategory handling
    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const subcategorySelect = document.getElementById('subcategory_id');
        
        // Clear subcategory select
        subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
        
        if (categoryId) {
            // Fetch subcategories via AJAX
            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        // Check if this should be selected
                        const selectedSubcategoryId = "{{ old('subcategory_id', $product->subcategory_id ?? '') }}";
                        if (subcategory.id == selectedSubcategoryId) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching subcategories:', error);
                });
        }
    });
    
    // Image removal function
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Edit form DOM fully loaded and parsed');
        
        // Handle delete image button clicks
        document.querySelectorAll('.delete-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-image-id');
                if (confirm('Are you sure you want to remove this image?')) {
                    // Add image ID to delete array
                    const deleteImagesInput = document.getElementById('deleteImagesInput');
                    let deleteImages = deleteImagesInput.value ? deleteImagesInput.value.split(',') : [];
                    
                    // Only add the image ID if it's not already in the array
                    if (!deleteImages.includes(imageId)) {
                        deleteImages.push(imageId);
                        deleteImagesInput.value = deleteImages.filter(id => id !== '').join(',');
                    }
                    
                    // Remove the image element from the DOM completely
                    const imageContainer = this.closest('.group');
                    if (imageContainer) {
                        imageContainer.remove();
                    }
                    
                    // Handle primary image selection after deletion
                    handlePrimaryImageAfterDeletion();
                }
            });
        });
        
        // Function to handle primary image selection after deletion
        function handlePrimaryImageAfterDeletion() {
            // Find all remaining images
            const remainingImages = document.querySelectorAll('.group');
            
            // If there are remaining images
            if (remainingImages.length > 0) {
                // Check if any image is currently marked as primary
                let hasPrimary = false;
                remainingImages.forEach(img => {
                    const checkbox = img.querySelector('.primary-image-checkbox');
                    if (checkbox && checkbox.checked) {
                        hasPrimary = true;
                    }
                });
                
                // If no primary image exists, make the first one primary
                if (!hasPrimary) {
                    const firstImage = remainingImages[0];
                    const firstCheckbox = firstImage.querySelector('.primary-image-checkbox');
                    if (firstCheckbox) {
                        firstCheckbox.checked = true;
                        // Trigger change event to update UI
                        firstCheckbox.dispatchEvent(new Event('change'));
                    }
                }
            }
        }
        
        // Handle primary image selection with checkboxes
        document.querySelectorAll('.primary-image-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const currentCheckbox = this;
                const imageId = this.value;
                
                // Uncheck all other checkboxes
                document.querySelectorAll('.primary-image-checkbox').forEach(otherCheckbox => {
                    if (otherCheckbox !== currentCheckbox) {
                        otherCheckbox.checked = false;
                    }
                });
                
                // Uncheck all new image radio buttons
                document.querySelectorAll('.primary-new-image-radio').forEach(radio => {
                    radio.checked = false;
                });
                
                // Update UI to show which image is primary
                document.querySelectorAll('.group').forEach(group => {
                    const checkboxInGroup = group.querySelector('.primary-image-checkbox');
                    const imageElement = group.querySelector('img');
                    
                    if (checkboxInGroup && checkboxInGroup.checked) {
                        // Add border to primary image
                        if (imageElement) {
                            imageElement.classList.add('border-2', 'border-blue-500');
                        }
                    } else {
                        // Remove border from non-primary images
                        if (imageElement) {
                            imageElement.classList.remove('border-2', 'border-blue-500');
                        }
                    }
                });
            });
        });
        
        // Handle click events on image containers
        document.querySelectorAll('.group').forEach(group => {
            group.addEventListener('click', function(e) {
                // Don't trigger if clicking on delete button
                if (e.target.closest('.delete-image-btn')) {
                    return;
                }
                
                // Toggle the checkbox when clicking on the image
                const checkbox = this.querySelector('.primary-image-checkbox');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    // Trigger change event to update UI
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
        
        // Add event listener to primary radio buttons for new images
        // We'll attach this when new images are added
        
        // Image preview functionality for new images
        const imageUpload = document.getElementById('imageUpload');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const noImagesMessage = document.getElementById('noImagesMessage');
        let imageFiles = [];
        let fileIdCounter = 0;

        if (imageUpload) {
            imageUpload.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                
                console.log('Files selected:', files);
                
                // Limit to 5 images (considering existing images)
                const existingImagesCount = {{ $product->images->count() }};
                const maxImages = 5;
                const totalImages = existingImagesCount + imageFiles.length;
                
                if (totalImages + files.length > maxImages) {
                    const remainingSlots = maxImages - totalImages;
                    alert(`You can only add ${remainingSlots} more image(s). Maximum 5 images allowed.`);
                    // Clear the input to allow selecting files again
                    e.target.value = '';
                    return;
                }
                
                // Process each file
                files.forEach(file => {
                    // Check if it's an image file (including webp)
                    if (!file.type.match('image.*')) {
                        alert('Please select only image files (JPEG, PNG, GIF, WEBP).');
                        // Clear the input to allow selecting files again
                        e.target.value = '';
                        return;
                    }
                    
                    // Check file size (2MB limit)
                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    if (file.size > maxSize) {
                        alert('File size exceeds 2MB limit.');
                        // Clear the input to allow selecting files again
                        e.target.value = '';
                        return;
                    }
                    
                    const fileId = fileIdCounter++;
                    imageFiles.push({
                        id: fileId,
                        file: file
                    });
                    
                    console.log('Added file to imageFiles array:', {
                        id: fileId,
                        fileName: file.name,
                        fileSize: file.size
                    });
                    
                    // Create preview element
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imagePreview = document.createElement('div');
                        imagePreview.className = 'border border-gray-200 rounded-lg p-3 relative';
                        imagePreview.dataset.fileId = fileId;
                        imagePreview.innerHTML = `
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <img src="${e.target.result}" alt="Preview" class="w-16 h-16 object-cover rounded">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                                    <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                                    <div class="mt-2 flex items-center">
                                        <input type="radio" name="primary_new_image" value="${fileId}" class="primary-new-image-radio mr-2">
                                        <label class="text-xs text-gray-600">Set as Primary</label>
                                    </div>
                                </div>
                                <button type="button" class="delete-new-image text-gray-400 hover:text-red-500" data-file-id="${fileId}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                        
                        imagePreviewContainer.appendChild(imagePreview);
                        noImagesMessage.classList.add('hidden');
                        
                        // Add event listener to delete button
                        imagePreview.querySelector('.delete-new-image').addEventListener('click', function() {
                            const fileId = this.getAttribute('data-file-id');
                            removeNewImage(fileId, imagePreview);
                        });
                        
                        // Add event listener to primary radio button
                        const primaryRadio = imagePreview.querySelector('.primary-new-image-radio');
                        primaryRadio.addEventListener('change', function() {
                            // Uncheck all other primary radio buttons
                            document.querySelectorAll('.primary-new-image-radio').forEach(radio => {
                                if (radio !== this) {
                                    radio.checked = false;
                                }
                            });
                            
                            // Uncheck all existing image checkboxes
                            document.querySelectorAll('.primary-image-checkbox').forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            
                            // Update UI for existing images to remove primary border
                            document.querySelectorAll('.group').forEach(group => {
                                const imageElement = group.querySelector('img');
                                if (imageElement) {
                                    imageElement.classList.remove('border-2', 'border-blue-500');
                                }
                            });
                        });
                        
                        // Auto-select first image as primary if none selected yet
                        if (imageFiles.length === 1) {
                            primaryRadio.checked = true;
                            // Trigger change event to update UI
                            primaryRadio.dispatchEvent(new Event('change'));
                        }
                    };
                    reader.readAsDataURL(file);
                });
                
                console.log('Current imageFiles array:', imageFiles);
            });
        }
        
        function removeNewImage(fileId, imageElement) {
            console.log('Removing image with ID:', fileId);
            
            // Remove from imageFiles array
            const originalLength = imageFiles.length;
            imageFiles = imageFiles.filter(item => item.id != fileId);
            console.log('Removed from imageFiles array. Before:', originalLength, 'After:', imageFiles.length);
            
            // Remove the preview element
            imageElement.remove();
            
            // Show no images message if no images left
            if (imagePreviewContainer.children.length === 1) { // Only the noImagesMessage remains
                noImagesMessage.classList.remove('hidden');
            }
            
            // Update the file input to reflect the removed files
            updateFileInput();
        }
        
        function updateFileInput() {
            if (imageFiles.length > 0) {
                const dataTransfer = new DataTransfer();
                imageFiles.forEach(item => {
                    dataTransfer.items.add(item.file);
                });
                imageUpload.files = dataTransfer.files;
                console.log('Updated file input with remaining files:', imageUpload.files.length);
            } else {
                // Clear the file input if no files left
                imageUpload.value = '';
                console.log('Cleared file input');
            }
        }
        
        // Handle form submission to ensure new images are submitted
        const form = document.getElementById('editProductForm');
        const submitButton = document.getElementById('updateProductBtn');
        
        console.log('Edit form element:', form);
        console.log('Edit submit button:', submitButton);
        
        if (form && submitButton) {
            console.log('Attaching event listeners to edit form');
            
            // Re-enable button if coming back from validation errors
            window.addEventListener('pageshow', function() {
                console.log('Edit page shown event triggered');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Update Product';
            });
            
            // Use submit event only (remove the old click event listener)
            // Remove the old event listeners and function
            form.removeEventListener('submit', form.submitEventHandler);
            submitButton.removeEventListener('click', submitButton.clickEventHandler);
            
            // Add new submit event listener
            form.addEventListener('submit', function(e) {
                console.log('Edit form submit event triggered');
                
                // Prevent multiple submissions
                if (submitButton.disabled) {
                    console.log('Edit form submission prevented - button already disabled');
                    e.preventDefault();
                    return false;
                }
                
                // Disable the submit button to prevent double submission
                submitButton.disabled = true;
                console.log('Edit button disabled');
                
                // Change button text to show loading state
                submitButton.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</span>';
                console.log('Edit button text changed to Processing...');
                
                // Prepare form data
                prepareEditFormData();
                
                // Allow form to submit normally
                console.log('Allowing edit form to submit normally');
            });
        } else {
            console.log('Edit form or submit button not found');
        }
        
        function prepareEditFormData() {
            console.log('=== Edit Form Submission Debug ===');
            
            // Log form submission
            console.log('Form submitting with new image files:', imageFiles);
            console.log('Image input files before submit:', imageUpload.files);
            console.log('Image input element:', imageUpload);
            console.log('Image input name attribute:', imageUpload.name);
            
            // Always ensure all image files are attached to the form submission
            if (imageFiles.length > 0) {
                console.log('Attaching files to input using DataTransfer');
                const dataTransfer = new DataTransfer();
                imageFiles.forEach(item => {
                    dataTransfer.items.add(item.file);
                    console.log('Adding file to DataTransfer:', item.file.name);
                });
                imageUpload.files = dataTransfer.files;
                console.log('Image input files after DataTransfer:', imageUpload.files);
                
                // Handle primary new image selection
                const primaryRadio = document.querySelector('input[name="primary_new_image"]:checked');
                if (primaryRadio) {
                    // Find the index of the selected file in the imageFiles array
                    const selectedIndex = imageFiles.findIndex(item => item.id == primaryRadio.value);
                    if (selectedIndex !== -1) {
                        // Create a hidden input to store the primary image index
                        let primaryImageInput = document.querySelector('input[name="primary_new_image_index"]');
                        if (!primaryImageInput) {
                            primaryImageInput = document.createElement('input');
                            primaryImageInput.type = 'hidden';
                            primaryImageInput.name = 'primary_new_image_index';
                            form.appendChild(primaryImageInput);
                        }
                        primaryImageInput.value = selectedIndex;
                    }
                }
            } else {
                // Clear the file input if no files left
                imageUpload.value = '';
                console.log('Cleared file input');
            }
            
            // Log each file in the input
            console.log('Final files in input:');
            for (let i = 0; i < imageUpload.files.length; i++) {
                console.log('File ' + i + ':', {
                    name: imageUpload.files[i].name,
                    size: imageUpload.files[i].size,
                    type: imageUpload.files[i].type
                });
            }
            
            console.log('=== End Edit Form Submission Debug ===');
        }
    });
</script>
@endsection