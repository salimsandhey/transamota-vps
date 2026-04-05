<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <?php echo $__env->make('layouts.nav.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <?php echo $__env->make('layouts.nav.content-header', [
                'title' => 'Manage Products',
                'subtitle' => 'View and manage all products uploaded by sellers',
                'headerActions' => ''
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Filters and Search -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                    <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Product name or description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Seller</label>
                            <select name="seller" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Sellers</option>
                                <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($seller->id); ?>" <?php echo e(request('seller') == $seller->id ? 'selected' : ''); ?>>
                                        <?php echo e($seller->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Verification Status</label>
                            <select name="verification_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Statuses</option>
                                <?php $__currentLoopData = $verificationStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php echo e(request('verification_status') == $status ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($status)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Filter
                            </button>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Products Table -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <!-- Bulk Actions -->
                    <div id="bulk-actions" class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <span id="selected-count">0</span> product(s) selected
                        </div>
                        <div class="flex space-x-2">
                            <form id="bulk-verify-form" method="POST" action="<?php echo e(route('admin.products.bulk-action')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="verify">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Verify Selected
                                </button>
                            </form>
                            
                            <button type="button" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    onclick="openBulkRejectModal()">
                                Reject Selected
                            </button>
                            
                            <form id="bulk-delete-form" method="POST" action="<?php echo e(route('admin.products.bulk-action')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                    Delete Selected
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="select-all" class="rounded text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 <?php echo e($product->verification_status === 'pending' ? 'bg-yellow-50' : ''); ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="product-checkbox rounded text-blue-600 focus:ring-blue-500" data-id="<?php echo e($product->id); ?>">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center">
                                                <?php if($product->primaryImage): ?>
                                                    <img src="<?php echo e(\App\Helpers\ImageHelper::getImageUrl($product->primaryImage->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="h-10 w-10 object-cover rounded-md">
                                                <?php else: ?>
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($product->name); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo e(Str::limit($product->description, 50)); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($product->seller->name); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($product->seller->email); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($product->category->name ?? 'N/A'); ?></div>
                                        <?php if($product->subcategory): ?>
                                            <div class="text-sm text-gray-500"><?php echo e($product->subcategory->name); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₹<?php echo e(number_format($product->price, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $verificationStatusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800'
                                            ];
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($verificationStatusColors[$product->verification_status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo e(ucfirst($product->verification_status)); ?>

                                        </span>
                                        <?php if($product->verification_status === 'pending'): ?>
                                            <div class="text-xs text-yellow-600 mt-1">Requires verification</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <?php if($product->verification_status === 'pending'): ?>
                                                <form action="<?php echo e(route('admin.products.verify', $product)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Verify">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <!-- Reject button that opens modal -->
                                                <button type="button" 
                                                        class="text-red-600 hover:text-red-900" 
                                                        title="Reject"
                                                        onclick="openRejectModal(<?php echo e($product->id); ?>)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No products found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <?php echo e($products->appends(request()->query())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const verifyIds = document.getElementById('verify-ids');
    const deleteIds = document.getElementById('delete-ids');
    const bulkVerifyForm = document.getElementById('bulk-verify-form');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActions();
            
            // Update select all checkbox state
            const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
        });
    });

    // Update bulk actions visibility and count
    function updateBulkActions() {
        const selectedCheckboxes = Array.from(productCheckboxes).filter(cb => cb.checked);
        const count = selectedCheckboxes.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }
        
        // Update form action URLs with array inputs
        if (count > 0) {
            const ids = selectedCheckboxes.map(cb => cb.dataset.id);
            
            // Update verify form
            updateFormWithIds(bulkVerifyForm, ids);
            
            // Update delete form
            updateFormWithIds(bulkDeleteForm, ids);
        }
    }
    
    // Helper function to update form with array of IDs
    function updateFormWithIds(form, ids) {
        // Remove existing ID inputs
        const existingInputs = form.querySelectorAll('input[name="ids[]"]');
        existingInputs.forEach(input => input.remove());
        
        // Add new ID inputs
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });
    }

    // Confirm bulk delete
    bulkDeleteForm.addEventListener('submit', function(e) {
        const count = Array.from(productCheckboxes).filter(cb => cb.checked).length;
        if (!confirm(`Are you sure you want to delete ${count} product(s)? This action cannot be undone.`)) {
            e.preventDefault();
        }
    });
});
    
    // Bulk reject modal functionality
    function openBulkRejectModal() {
        // Create modal if it doesn't exist
        if (!document.getElementById('bulkRejectModal')) {
            const modalHtml = `
                <div id="bulkRejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Reject Selected Products</h3>
                                <button onclick="closeBulkRejectModal()" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form id="bulkRejectForm" method="POST" action="<?php echo e(route('admin.products.bulk-action')); ?>" class="mt-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="reject">
                                <div class="mb-4">
                                    <label for="bulk_rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                                    <textarea id="bulk_rejection_reason" name="rejection_reason" rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                              placeholder="Please provide a reason for rejecting these products..." required></textarea>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="closeBulkRejectModal()" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Reject Products
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Add event listener to the form
            document.getElementById('bulkRejectForm').addEventListener('submit', function(e) {
                // Get selected checkboxes
                const selectedCheckboxes = Array.from(document.querySelectorAll('.product-checkbox')).filter(cb => cb.checked);
                const ids = selectedCheckboxes.map(cb => cb.dataset.id);
                
                // Add ID inputs to the form
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    this.appendChild(input);
                });
            });
        } else {
            // Clear existing ID inputs
            const existingInputs = document.querySelectorAll('#bulkRejectForm input[name="ids[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Add new ID inputs
            const selectedCheckboxes = Array.from(document.querySelectorAll('.product-checkbox')).filter(cb => cb.checked);
            const ids = selectedCheckboxes.map(cb => cb.dataset.id);
            
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                document.getElementById('bulkRejectForm').appendChild(input);
            });
        }
        
        // Show modal
        document.getElementById('bulkRejectModal').classList.remove('hidden');
        document.getElementById('bulk_rejection_reason').value = '';
    }
    
    function closeBulkRejectModal() {
        document.getElementById('bulkRejectModal').classList.add('hidden');
    }
    
    // Individual reject modal functionality
    function openRejectModal(productId) {
        // Create modal if it doesn't exist
        if (!document.getElementById('rejectModal')) {
            const modalHtml = `
                <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Reject Product</h3>
                                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form id="rejectForm" method="POST" class="mt-4">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="product_id" id="reject_product_id">
                                <div class="mb-4">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                              placeholder="Please provide a reason for rejecting this product..." required></textarea>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="closeRejectModal()" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Reject Product
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Add event listener to the form
            document.getElementById('rejectForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const productId = document.getElementById('reject_product_id').value;
                const rejectionReason = document.getElementById('rejection_reason').value;
                
                // Create a hidden form to submit the data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${productId}/reject`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '<?php echo e(csrf_token()); ?>';
                form.appendChild(csrfInput);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                form.appendChild(methodInput);
                
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'rejection_reason';
                reasonInput.value = rejectionReason;
                form.appendChild(reasonInput);
                
                document.body.appendChild(form);
                form.submit();
            });
        }
        
        // Set product ID and show modal
        document.getElementById('reject_product_id').value = productId;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejection_reason').value = '';
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const rejectModal = document.getElementById('rejectModal');
        const bulkRejectModal = document.getElementById('bulkRejectModal');
        
        if (rejectModal && !rejectModal.classList.contains('hidden') && event.target === rejectModal) {
            closeRejectModal();
        }
        
        if (bulkRejectModal && !bulkRejectModal.classList.contains('hidden') && event.target === bulkRejectModal) {
            closeBulkRejectModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/admin/products/index.blade.php ENDPATH**/ ?>