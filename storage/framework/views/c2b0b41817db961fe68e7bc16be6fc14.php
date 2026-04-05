<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Breadcrumb -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <nav class="flex text-sm" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="<?php echo e(route('welcome')); ?>" class="text-gray-500 hover:text-blue-600">Home</a>
                            </li>
                            <li>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </li>
                            <li class="text-gray-900">Products</li>
                            <?php if(request('search')): ?>
                            <li>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </li>
                            <li class="text-gray-900">Search: "<?php echo e(request('search')); ?>"</li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6">
                    <!-- Filters -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Filter Products</h3>
                            <button id="toggle-filters" class="md:hidden flex items-center gap-2 text-blue-600 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Show Filters
                            </button>
                        </div>
                        
                        <div id="filters-container" class="hidden md:block">
                            <form method="GET" action="<?php echo e(route('products.browse')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <!-- Search Filter -->
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                        placeholder="Search products...">
                                </div>
                                
                                <!-- Category Filter -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <!-- Subcategory Filter -->
                                <div>
                                    <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
                                    <select name="subcategory" id="subcategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Subcategories</option>
                                        <!-- Will be populated dynamically -->
                                    </select>
                                </div>
                                
                                <!-- Price Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                    <div class="flex gap-2">
                                        <input type="number" name="min_price" placeholder="Min" value="<?php echo e(request('min_price')); ?>" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <input type="number" name="max_price" placeholder="Max" value="<?php echo e(request('max_price')); ?>" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    </div>
                                </div>
                                
                                <!-- Country Filter -->
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <select name="country" id="country" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Countries</option>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country); ?>" <?php echo e(request('country') == $country ? 'selected' : ''); ?>>
                                                <?php echo e($country); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <!-- Verified Seller -->
                                <div class="flex items-end">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="verified_seller" value="1" <?php echo e(request('verified_seller') ? 'checked' : ''); ?> class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Verified Sellers</span>
                                    </label>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="md:col-span-5 flex justify-end gap-3 pt-2">
                                    <a href="<?php echo e(route('products.browse')); ?>" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                                        Clear Filters
                                    </a>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Sorting and Results Info -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div class="text-sm text-gray-600">
                            Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> products
                            <?php if(request('search')): ?>
                                for search term "<?php echo e(request('search')); ?>"
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option>Sort by: Latest</option>
                                <option>Sort by: Popular</option>
                                <option>Sort by: Featured</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            <div class="h-48 bg-white relative">
                                <?php if($product->primaryImage): ?>
                                    <img src="/storage/<?php echo e($product->primaryImage->image_path); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-contain p-2">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if(auth()->guard()->check()): ?>
                                <button 
                                    data-product-id="<?php echo e($product->id); ?>"
                                    class="favorite-btn absolute top-2 right-2 bg-white rounded-full p-2 shadow-md"
                                    title="<?php echo e(auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'Remove from favorites' : 'Add to favorites'); ?>">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path class="<?php echo e(auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'text-red-500 fill-current' : 'text-gray-400 fill-current border border-red-500'); ?>" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h4 class="font-medium text-gray-800 mb-1"><?php echo e(Str::limit($product->name, 30)); ?></h4>
                                <p class="text-sm text-gray-500 mb-2"><?php echo e(Str::limit($product->description, 50)); ?></p>
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900">
                                        <?php if($product->price): ?>
                                            ₹<?php echo e(number_format($product->price, 2)); ?>

                                        <?php else: ?>
                                            Price on request
                                        <?php endif; ?>
                                    </span>
                                    <a href="<?php echo e(route('products.show', $product->id)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </a>
                                </div>
                                <div class="mt-2 flex items-center text-xs text-gray-500">
                                    <span><?php echo e($product->origin_country); ?></span>
                                    <?php if($product->seller->is_verified): ?>
                                        <span class="ml-2 flex items-center text-blue-600">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-gray-500">
                                <?php if(request('search')): ?>
                                    No products found matching your search for "<?php echo e(request('search')); ?>". Try different keywords.
                                <?php else: ?>
                                    No products found matching your criteria.
                                <?php endif; ?>
                            </p>
                            <a href="<?php echo e(route('products.browse')); ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Clear Filters
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-600">
                            Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> products
                        </div>
                        <div class="flex items-center gap-2">
                            <?php echo e($products->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button clicks
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Disable the button temporarily to prevent double clicks
            const originalButton = this;
            originalButton.disabled = true;
            
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                const svgPath = this.querySelector('svg path');
                
                // Reset all classes
                svgPath.classList.remove('text-white', 'text-gray-400', 'text-red-500', 'fill-current', 'border', 'border-red-500');
                
                if (data.favorited) {
                    // Set favorited state (red heart)
                    svgPath.classList.add('text-red-500', 'fill-current');
                    this.title = 'Remove from favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                } else {
                    // Set unfavorited state (gray heart with red border)
                    svgPath.classList.add('text-gray-400', 'fill-current', 'border', 'border-red-500');
                    this.title = 'Add to favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.show('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                // Re-enable the button
                originalButton.disabled = false;
            });
        });
    });
    
    // Toggle filters on mobile
    const toggleButton = document.getElementById('toggle-filters');
    const filtersContainer = document.getElementById('filters-container');
    
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            filtersContainer.classList.toggle('hidden');
            this.querySelector('span').textContent = filtersContainer.classList.contains('hidden') ? 'Show Filters' : 'Hide Filters';
        });
    }
    
    // Populate subcategories based on category selection
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    
    // Populate subcategories on page load if category is selected
    const selectedCategoryId = "<?php echo e(request('category')); ?>";
    const selectedSubcategoryId = "<?php echo e(request('subcategory')); ?>";
    
    if (selectedCategoryId) {
        fetch(`/products/subcategories?category_id=${selectedCategoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    if (subcategory.id == selectedSubcategoryId) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subcategories:', error));
    }
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            // Clear existing options
            subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
            
            if (categoryId) {
                // Fetch subcategories via AJAX
                fetch(`/products/subcategories?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching subcategories:', error));
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Favorite functionality is already handled in the main script above
// This section is intentionally left empty to avoid duplicate event listeners
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/public/products/browse.blade.php ENDPATH**/ ?>