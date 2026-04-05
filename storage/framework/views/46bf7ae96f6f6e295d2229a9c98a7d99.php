<!-- Breadcrumb Style Content Header -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
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
                    <li class="text-gray-900"><?php echo e($title ?? 'Dashboard'); ?></li>
                </ol>
            </nav>
            
            <?php if(isset($headerActions) && $headerActions): ?>
                <div class="flex items-center gap-2">
                    <?php echo $headerActions; ?>

                </div>
            <?php endif; ?>
        </div>
        
        <?php if(isset($subtitle) && $subtitle): ?>
            <!-- <p class="text-sm text-gray-500 mt-1"><?php echo e($subtitle); ?></p> -->
        <?php endif; ?>
    </div>
</div><?php /**PATH /var/www/transamota.com/resources/views/layouts/nav/content-header.blade.php ENDPATH**/ ?>