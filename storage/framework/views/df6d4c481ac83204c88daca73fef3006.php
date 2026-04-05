<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <?php echo $__env->make('layouts.nav.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- <?php echo $__env->make('layouts.nav.admin-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> -->
            
            <?php echo $__env->make('layouts.nav.content-header', [
                'title' => 'Product Verification',
                'subtitle' => 'Review and verify products submitted by sellers',
                'headerActions' => ''
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

            <!-- Product Verification -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Product Verification</h3>
                            <p class="text-sm text-gray-600">Review and verify products submitted by sellers. Only verified products will be visible to buyers.</p>
                        </div>
                    </div>
                    
                    <!-- Product Filters -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <form method="GET" action="<?php echo e(route('admin.verifications.products.index')); ?>">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Product name or description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                                <?php echo e($cat->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Seller</label>
                                    <select name="seller" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Sellers</option>
                                        <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sel->id); ?>" <?php echo e(request('seller') == $sel->id ? 'selected' : ''); ?>>
                                                <?php echo e($sel->name); ?>

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
                                    <a href="<?php echo e(route('admin.verifications.products.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <?php if($productsPendingVerification->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 font-medium">Product</th>
                                        <th class="pb-3 font-medium">Seller</th>
                                        <th class="pb-3 font-medium">Category</th>
                                        <th class="pb-3 font-medium">Price</th>
                                        <th class="pb-3 font-medium">Submitted</th>
                                        <th class="pb-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php $__currentLoopData = $productsPendingVerification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <?php if($product->primaryImage): ?>
                                                    <img src="<?php echo e(asset('storage/' . $product->primaryImage->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="w-10 h-10 rounded-lg object-cover">
                                                <?php else: ?>
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="font-medium text-gray-800 text-sm"><?php echo e($product->name); ?></div>
                                                    <div class="text-xs text-gray-500"><?php echo e(Str::limit($product->description, 30)); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm text-gray-600"><?php echo e($product->seller->name); ?></div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm text-gray-600"><?php echo e($product->category->name ?? 'N/A'); ?></div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm font-medium text-gray-800">₹<?php echo e(number_format($product->price, 2)); ?></div>
                                        </td>
                                        <td class="py-4 text-sm text-gray-600">
                                            <?php echo e($product->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="<?php echo e(route('admin.verifications.products.show', $product)); ?>" class="text-blue-600 hover:text-blue-800 cursor-pointer" title="View Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <?php if($product->verification_status === 'pending'): ?>
                                                <form method="POST" action="<?php echo e(route('admin.verifications.products.approve', $product)); ?>" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-800 cursor-pointer"
                                                            title="Approve Product">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="<?php echo e(route('admin.verifications.products.reject', $product)); ?>" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="button" 
                                                            class="text-red-600 hover:text-red-800 cursor-pointer"
                                                            title="Reject Product"
                                                            onclick="openRejectModal(<?php echo e($product->id); ?>)">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-500">
                                                        <?php echo e(ucfirst($product->verification_status)); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if(method_exists($productsPendingVerification, 'hasPages') && $productsPendingVerification->hasPages()): ?>
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-gray-600">
                                Showing <?php echo e($productsPendingVerification->firstItem()); ?> to <?php echo e($productsPendingVerification->lastItem()); ?> of <?php echo e($productsPendingVerification->total()); ?> results
                            </div>
                            <div class="mt-4">
                                <?php echo e($productsPendingVerification->appends(request()->query())->links()); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products to verify</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no products matching your search criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Function to open rejection modal
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
            form.action = `/admin/verifications/products/${productId}/reject`;
            
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

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('rejectModal');
    if (modal && !modal.classList.contains('hidden') && event.target === modal) {
        closeRejectModal();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/admin/verifications/products.blade.php ENDPATH**/ ?>