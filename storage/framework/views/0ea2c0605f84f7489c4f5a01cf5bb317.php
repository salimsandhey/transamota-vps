<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <?php echo $__env->make('layouts.nav.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="mb-6">
                    <a href="<?php echo e(route('admin.contact-messages.index')); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Messages
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Contact Message Details</h1>
                </div>
                
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800"><?php echo e($contactMessage->subject); ?></h2>
                            <div class="flex items-center mt-2 text-sm text-gray-600">
                                <span class="mr-4">From: <?php echo e($contactMessage->name); ?></span>
                                <span><?php echo e($contactMessage->email); ?></span>
                            </div>
                        </div>
                        <span class="px-3 py-1 <?php echo e($contactMessage->is_read ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'); ?> text-sm rounded-full">
                            <?php echo e($contactMessage->is_read ? 'Read' : 'Unread'); ?>

                        </span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($contactMessage->message); ?></p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6 mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Sent on <?php echo e($contactMessage->created_at->format('F j, Y \a\t g:i A')); ?>

                        </div>
                        <div class="flex gap-2">
                            <form action="<?php echo e(route('admin.contact-messages.destroy', $contactMessage)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    Delete Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/admin/contact-messages/show.blade.php ENDPATH**/ ?>