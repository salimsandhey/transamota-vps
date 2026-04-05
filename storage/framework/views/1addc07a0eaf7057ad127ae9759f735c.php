<nav class="bg-white shadow sticky top-0">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center">
                    <a href="<?php echo e(route('welcome')); ?>" class="text-xl font-bold text-gray-900">Admin Panel</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <?php if(Auth::check()): ?>
                            <span class="text-sm font-medium text-gray-700"><?php echo e(Auth::user()->name); ?></span>
                            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    Logout
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('admin.login')); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav><?php /**PATH /var/www/transamota.com/resources/views/layouts/nav/admin-header.blade.php ENDPATH**/ ?>