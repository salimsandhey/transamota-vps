<?php $__env->startSection('title', 'Forgot Password - Transamota'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50 items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                            <div class="text-white font-bold text-xl">T</div>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Forgot Password</h2>
                    <p class="text-gray-600 mt-2">Enter your email address and we'll send you a link to reset your password.</p>
                </div>
                
                <?php if(session('status')): ?>
                    <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-lg">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('password.email')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="you@example.com" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Send Password Reset Link
                    </button>
                </form>
                
                <div class="mt-6 text-center text-sm text-gray-600">
                    <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-800 font-medium">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/transamota.com/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>