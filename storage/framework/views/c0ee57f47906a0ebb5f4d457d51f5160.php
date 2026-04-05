<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <?php echo $__env->make('layouts.nav.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <?php echo $__env->make('layouts.nav.content-header', [
                'title' => 'Category Management',
                'subtitle' => 'Manage product categories and subcategories',
                'headerActions' => '<a href="' . route('admin.categories.create') . '" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Category
                </a>'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Success/Error Messages -->
            <?php if(session('success')): ?>
                <div class="mx-8 mt-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div class="text-green-800 font-medium"><?php echo e(session('success')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-red-800 font-medium"><?php echo e(session('error')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Categories Table -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <h3 class="text-lg font-semibold text-gray-800">Categories</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="GET" class="flex gap-2">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Search categories..." 
                                        value="<?php echo e(request('search')); ?>"
                                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Filter
                                </button>
                                
                                <?php if(request()->has('search')): ?>
                                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">
                                        Clear
                                    </a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Category</th>
                                    <th class="pb-3 font-medium">Description</th>
                                    <th class="pb-3 font-medium">Products</th>
                                    <th class="pb-3 font-medium">Subcategories</th>
                                    <th class="pb-3 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($category->icon): ?>
                                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <?php echo $category->icon; ?>

                                                </div>
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="font-medium text-gray-800 text-sm"><?php echo e($category->name); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo e($category->slug); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm text-gray-600 max-w-xs truncate">
                                        <?php echo e($category->description ?? 'No description'); ?>

                                    </td>
                                    <td class="py-4">
                                        <a href="<?php echo e(route('admin.categories.products', $category)); ?>" class="text-blue-600 hover:text-blue-800">
                                            <?php echo e($category->products_count); ?> products
                                        </a>
                                    </td>
                                    <td class="py-4">
                                        <a href="<?php echo e(route('admin.categories.subcategories.index', $category)); ?>" class="text-blue-600 hover:text-blue-800">
                                            <?php echo e($category->subcategories()->count()); ?> subcategories
                                        </a>
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                               class="text-gray-500 hover:text-gray-700" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <button class="text-red-600 hover:text-red-800 delete-category-btn" 
                                                    title="Delete"
                                                    data-category-id="<?php echo e($category->id); ?>"
                                                    data-category-name="<?php echo e($category->name); ?>">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>No categories found</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if(method_exists($categories, 'hasPages') && $categories->hasPages()): ?>
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-600">
                            Showing <?php echo e($categories->firstItem()); ?> to <?php echo e($categories->lastItem()); ?> of <?php echo e($categories->total()); ?> results
                        </div>
                        <div class="mt-4">
                            <?php echo e($categories->links()); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete category
    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            const categoryName = this.getAttribute('data-category-name');
            
            // Show custom confirmation popup
            showDeleteConfirmation(categoryName, function() {
                // Proceed with deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/categories/${categoryId}`;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
});

// Custom delete confirmation popup (same as seller products)
function showDeleteConfirmation(categoryName, onConfirm) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.id = 'delete-confirmation-overlay';
    
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'bg-white rounded-lg p-6 max-w-md w-full mx-4';
    modal.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Delete Category</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <p class="text-gray-600 mb-6">Are you sure you want to delete the category "<strong>${categoryName}</strong>"? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button id="cancel-delete" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Delete
            </button>
        </div>
    `;
    
    overlay.appendChild(modal);
    document.body.appendChild(overlay);
    
    // Add event listeners
    document.getElementById('close-modal').addEventListener('click', function() {
        document.body.removeChild(overlay);
    });
    
    document.getElementById('cancel-delete').addEventListener('click', function() {
        document.body.removeChild(overlay);
    });
    
    document.getElementById('confirm-delete').addEventListener('click', function() {
        document.body.removeChild(overlay);
        onConfirm();
    });
    
    // Close on escape key
    document.addEventListener('keydown', function closeOnEscape(e) {
        if (e.key === 'Escape') {
            document.body.removeChild(overlay);
            document.removeEventListener('keydown', closeOnEscape);
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>