<!-- Admin Sidebar -->
<div class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <!-- Logo -->
    <!-- <div class="p-6 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <div class="text-white font-bold text-sm">T</div>
            </div>
            <span class="text-xl font-semibold text-gray-800">Transamota</span>
        </div>
    </div> -->

    <!-- User Profile -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-medium text-gray-800"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                <div class="text-xs text-gray-500">Administrator</div>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="flex-1 overflow-y-auto p-4">
        <div class="text-xs font-semibold text-gray-500 mb-3">Main Menu</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('admin.dashboard')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="flex-1 text-left">Dashboard</span>
            </a>
        </div>

        <div class="text-xs font-semibold text-gray-500 mt-6 mb-3">User Management</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('admin.users.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.users.*') && !request()->routeIs('admin.verifications.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="flex-1 text-left">Users</span>
            </a>
        </div>

        <!-- Verification Section -->
        <div class="text-xs font-semibold text-gray-500 mt-6 mb-3">Verification</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('admin.verifications.users.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.verifications.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span class="flex-1 text-left">User Verification</span>
            </a>
            <a href="<?php echo e(route('admin.verifications.products.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.verifications.products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="flex-1 text-left">Product Verification</span>
            </a>
        </div>

        <div class="text-xs font-semibold text-gray-500 mt-6 mb-3">Content Management</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="flex-1 text-left">Categories</span>
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="flex-1 text-left">Products</span>
            </a>
        </div>

        <div class="text-xs font-semibold text-gray-500 mt-6 mb-3">Other Menu</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('admin.contact-messages.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?php echo e(request()->routeIs('admin.contact-messages.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <span class="flex-1 text-left">Contact Messages</span>
                <?php if(App\Models\ContactMessage::where('is_read', false)->count() > 0): ?>
                    <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                        <?php echo e(App\Models\ContactMessage::where('is_read', false)->count()); ?>

                    </span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.settings.index')); ?>" 
               class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="flex-1 text-left">Settings</span>
            </a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="flex-1 text-left">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div><?php /**PATH /var/www/transamota.com/resources/views/layouts/nav/admin-sidebar.blade.php ENDPATH**/ ?>