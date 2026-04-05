<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <?php echo $__env->make('layouts.nav.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <?php echo $__env->make('layouts.nav.content-header', [
                'title' => 'User Verification',
                'subtitle' => 'Verify seller documents and approve buyers',
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

            <!-- Verification Tabs -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="flex space-x-8">
                            <button data-tab="sellers" class="tab-button py-4 px-1 border-b-2 border-blue-500 text-sm font-medium text-blue-600 active">
                                Seller Documents
                            </button>
                            <button data-tab="buyers" class="tab-button py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Buyer Approvals
                            </button>
                        </nav>
                    </div>

                    <!-- Seller Documents Tab -->
                    <div id="sellers-tab" class="tab-content">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Seller Documents</h3>
                                <p class="text-sm text-gray-600">Review and verify business documents uploaded by sellers. Once verified, sellers can access all seller features.</p>
                            </div>
                        </div>
                        
                        <!-- Seller Filters -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <form method="GET" id="seller-filter-form">
                                <input type="hidden" name="active_tab" value="sellers">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="seller_search" class="block text-sm font-medium text-gray-700 mb-1">Search Sellers</label>
                                        <input type="text" name="seller_search" id="seller_search" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3"
                                               placeholder="Name or email"
                                               value="<?php echo e(request('seller_search')); ?>">
                                    </div>
                                    <div>
                                        <label for="seller_status" class="block text-sm font-medium text-gray-700 mb-1">Verification Status</label>
                                        <select name="seller_status" id="seller_status"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                                            <option value="">All Statuses</option>
                                            <option value="verified" <?php echo e(request('seller_status') === 'verified' ? 'selected' : ''); ?>>Verified</option>
                                            <option value="pending" <?php echo e(request('seller_status') === 'pending' ? 'selected' : ''); ?>>Pending Verification</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end">
                                        <div class="space-x-2">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Apply Filters
                                            </button>
                                            <a href="<?php echo e(route('admin.verifications.users.index')); ?>?active_tab=sellers" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <?php if($sellersWithDocuments->count() > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                            <th class="pb-3 font-medium">Seller</th>
                                            <th class="pb-3 font-medium">Document</th>
                                            <th class="pb-3 font-medium">Status</th>
                                            <th class="pb-3 font-medium">Submitted</th>
                                            <th class="pb-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php $__currentLoopData = $sellersWithDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800 text-sm"><?php echo e($user->name); ?></div>
                                                        <div class="text-xs text-gray-500"><?php echo e($user->email); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="text-sm text-gray-600">
                                                    Business Document
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    <?php if($user->profile->verified_by_admin): ?> bg-green-100 text-green-800 
                                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                    <?php if($user->profile->verified_by_admin): ?> Verified <?php else: ?> Pending Verification <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="py-4 text-sm text-gray-600">
                                                <?php echo e($user->profile->updated_at->format('M d, Y')); ?>

                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="<?php echo e(route('admin.verifications.users.seller.show', $user)); ?>" 
                                                       class="text-blue-600 hover:text-blue-800 cursor-pointer" title="View Details">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <?php if(!$user->profile->verified_by_admin): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.verifications.users.seller.verify', $user)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-800 cursor-pointer"
                                                                title="Verify Document">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                    
                                                    <form method="POST" action="<?php echo e(route('admin.verifications.users.seller.reject', $user)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800 cursor-pointer"
                                                                title="Reject Document"
                                                                onclick="return confirm('Are you sure you want to reject this document?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination for Sellers -->
                            <?php if(method_exists($sellersWithDocuments, 'hasPages') && $sellersWithDocuments->hasPages()): ?>
                            <div class="flex items-center justify-between mt-6">
                                <div class="text-sm text-gray-600">
                                    Showing <?php echo e($sellersWithDocuments->firstItem()); ?> to <?php echo e($sellersWithDocuments->lastItem()); ?> of <?php echo e($sellersWithDocuments->total()); ?> results
                                </div>
                                <div class="mt-4">
                                    <?php echo e($sellersWithDocuments->appends(request()->except('sellers_page'))->appends('active_tab', 'sellers')->links()); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No documents to verify</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no seller documents pending verification. All sellers have either verified documents or haven't uploaded any yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Buyer Approvals Tab -->
                    <div id="buyers-tab" class="tab-content hidden">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Buyer Approvals</h3>
                                <p class="text-sm text-gray-600">Approve or reject buyer accounts. Approved buyers can message sellers and request quotes.</p>
                            </div>
                        </div>
                        
                        <!-- Buyer Filters -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <form method="GET" id="buyer-filter-form">
                                <input type="hidden" name="active_tab" value="buyers">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="buyer_search" class="block text-sm font-medium text-gray-700 mb-1">Search Buyers</label>
                                        <input type="text" name="buyer_search" id="buyer_search" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3"
                                               placeholder="Name or email"
                                               value="<?php echo e(request('buyer_search')); ?>">
                                    </div>
                                    <div>
                                        <label for="buyer_status" class="block text-sm font-medium text-gray-700 mb-1">Approval Status</label>
                                        <select name="buyer_status" id="buyer_status"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                                            <option value="">All Statuses</option>
                                            <option value="approved" <?php echo e(request('buyer_status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                            <option value="pending" <?php echo e(request('buyer_status') === 'pending' ? 'selected' : ''); ?>>Pending Approval</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end">
                                        <div class="space-x-2">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Apply Filters
                                            </button>
                                            <a href="<?php echo e(route('admin.verifications.users.index')); ?>?active_tab=buyers" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <?php if($buyers->count() > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                            <th class="pb-3 font-medium">Buyer</th>
                                            <th class="pb-3 font-medium">Email Status</th>
                                            <th class="pb-3 font-medium">Status</th>
                                            <th class="pb-3 font-medium">Registered</th>
                                            <th class="pb-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php $__currentLoopData = $buyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800 text-sm"><?php echo e($user->name); ?></div>
                                                        <div class="text-xs text-gray-500"><?php echo e($user->email); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    <?php if($user->email_verified_at): ?> bg-green-100 text-green-800 
                                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                    <?php if($user->email_verified_at): ?> Verified <?php else: ?> Unverified <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    <?php if($user->is_verified): ?> bg-green-100 text-green-800 
                                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                    <?php if($user->is_verified): ?> Approved <?php else: ?> Pending Approval <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="py-4 text-sm text-gray-600">
                                                <?php echo e($user->created_at->format('M d, Y')); ?>

                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="<?php echo e(route('admin.verifications.users.buyer.show', $user)); ?>" 
                                                       class="text-blue-600 hover:text-blue-800 cursor-pointer" title="View Details">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <?php if(!$user->is_verified): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.verifications.users.buyer.approve', $user)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-800 cursor-pointer"
                                                                title="Approve Buyer">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                    
                                                    <form method="POST" action="<?php echo e(route('admin.verifications.users.buyer.reject', $user)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800 cursor-pointer"
                                                                title="Reject Buyer"
                                                                onclick="return confirm('Are you sure you want to reject this buyer?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination for Buyers -->
                            <?php if(method_exists($buyers, 'hasPages') && $buyers->hasPages()): ?>
                            <div class="flex items-center justify-between mt-6">
                                <div class="text-sm text-gray-600">
                                    Showing <?php echo e($buyers->firstItem()); ?> to <?php echo e($buyers->lastItem()); ?> of <?php echo e($buyers->total()); ?> results
                                </div>
                                <div class="mt-4">
                                    <?php echo e($buyers->appends(request()->except('buyers_page'))->appends('active_tab', 'buyers')->links()); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No buyers to approve</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no buyers pending approval. All buyers have either been approved or rejected.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active', 'text-blue-600', 'border-blue-500'));
            tabButtons.forEach(btn => btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent'));
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Add active class to clicked button
            this.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            this.classList.add('active', 'text-blue-600', 'border-blue-500');
            
            // Show corresponding content
            const tabName = this.getAttribute('data-tab');
            document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        });
    });
    
    // Set active tab based on URL parameter or default to sellers
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('active_tab') || 'sellers';
    
    // Activate the appropriate tab
    const activeTabButton = document.querySelector(`[data-tab="${activeTab}"]`);
    const activeTabContent = document.getElementById(`${activeTab}-tab`);
    
    if (activeTabButton && activeTabContent) {
        // Ensure all tabs are properly reset
        tabButtons.forEach(btn => {
            btn.classList.remove('active', 'text-blue-600', 'border-blue-500');
            btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
        });
        
        // Set active tab
        activeTabButton.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
        activeTabButton.classList.add('active', 'text-blue-600', 'border-blue-500');
        
        // Hide all content
        tabContents.forEach(content => content.classList.add('hidden'));
        
        // Show active content
        activeTabContent.classList.remove('hidden');
    }
    
    // Auto-submit forms when filter values change
    const sellerStatusFilter = document.getElementById('seller_status');
    const buyerStatusFilter = document.getElementById('buyer_status');
    
    if (sellerStatusFilter) {
        sellerStatusFilter.addEventListener('change', function() {
            document.getElementById('seller-filter-form').submit();
        });
    }
    
    if (buyerStatusFilter) {
        buyerStatusFilter.addEventListener('change', function() {
            document.getElementById('buyer-filter-form').submit();
        });
    }
    
    // Handle Enter key in search fields
    const sellerSearchInput = document.getElementById('seller_search');
    const buyerSearchInput = document.getElementById('buyer_search');
    
    if (sellerSearchInput) {
        sellerSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('seller-filter-form').submit();
            }
        });
    }
    
    if (buyerSearchInput) {
        buyerSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('buyer-filter-form').submit();
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/admin/verifications/users.blade.php ENDPATH**/ ?>