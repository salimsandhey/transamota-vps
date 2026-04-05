<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <?php if(isset($categories)): ?>
                        <?php $__currentLoopData = $categories->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('products.browse', ['category' => $category->id])); ?>" class="hover:text-blue-600"><?php echo e($category->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('products.browse')); ?>" class="hover:text-blue-600">All Categories</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-gray-900 mb-4">More Categories</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <?php if(isset($categories)): ?>
                        <?php $__currentLoopData = $categories->skip(4)->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('products.browse', ['category' => $category->id])); ?>" class="hover:text-blue-600"><?php echo e($category->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('products.browse')); ?>" class="hover:text-blue-600">All Categories</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Sell</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="<?php echo e(route('sell')); ?>" class="hover:text-blue-600">Sell on Transamota</a></li>
                    <li><a href="<?php echo e(route('how-to-sell')); ?>" class="hover:text-blue-600">How to Sell</a></li>
                    <li><a href="<?php echo e(route('business-accounts')); ?>" class="hover:text-blue-600">Business Accounts</a></li>
                    <li><a href="<?php echo e(route('advertise')); ?>" class="hover:text-blue-600">Advertise</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Help & Support</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="<?php echo e(route('faq')); ?>" class="hover:text-blue-600">FAQ</a></li>
                    <li><a href="<?php echo e(route('safety-tips')); ?>" class="hover:text-blue-600">Safety Tips</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-blue-600">Contact Us</a></li>
                </ul>
            </div>
            
        </div>
        
        <div class="border-t border-gray-200 mt-8 pt-6 text-center text-sm text-gray-500">
            &copy; <?php echo e(date('Y')); ?> Transamota. All rights reserved.
        </div>
    </div>
</footer><?php /**PATH /var/www/transamota.com/resources/views/layouts/nav/footer.blade.php ENDPATH**/ ?>