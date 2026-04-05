<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Transamota')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Additional styles for responsive sidebar and header -->
    <style>
        @media (max-width: 767px) {
            .mobile-sidebar-open {
                overflow: hidden;
            }
        }
        
        /* Ensure header stays on top */
        header.sticky {
            z-index: 1000;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen">
        <!-- Conditional header based on route prefix -->
        <?php if(str_starts_with(request()->path(), 'admin')): ?>
            <?php echo $__env->make('layouts.nav.admin-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif(str_starts_with(request()->path(), 'seller')): ?>
            <?php echo $__env->make('layouts.nav.seller-public-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif(str_starts_with(request()->path(), 'chat')): ?>
            <?php echo $__env->make('layouts.nav.seller-public-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('layouts.nav.public-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        
        <!-- Main content area -->
        <main class="flex-grow">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        
        <!-- Conditionally include footer - exclude from admin, buyer, seller, chat, and group-chat routes -->
        <?php if (! (
            str_starts_with(request()->path(), 'admin') || 
            str_starts_with(request()->path(), 'buyer') || 
            str_starts_with(request()->path(), 'seller') ||
            str_starts_with(request()->path(), 'chat') ||
            str_starts_with(request()->path(), 'group-chat')
        )): ?>
            <?php echo $__env->make('layouts.nav.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        
        <?php echo $__env->yieldContent('scripts'); ?>
    </div>
</body>
</html><?php /**PATH /var/www/transamota.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>