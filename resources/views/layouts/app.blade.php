<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Transamota') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
        @if(str_starts_with(request()->path(), 'admin'))
            @include('layouts.nav.admin-header')
        @elseif(str_starts_with(request()->path(), 'seller'))
            @include('layouts.nav.seller-public-header')
        @elseif(str_starts_with(request()->path(), 'chat'))
            @include('layouts.nav.seller-public-header')
        @else
            @include('layouts.nav.public-header')
        @endif
        
        <!-- Main content area -->
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <!-- Conditionally include footer - exclude from admin, buyer, seller, chat, and group-chat routes -->
        @unless(
            str_starts_with(request()->path(), 'admin') || 
            str_starts_with(request()->path(), 'buyer') || 
            str_starts_with(request()->path(), 'seller') ||
            str_starts_with(request()->path(), 'chat') ||
            str_starts_with(request()->path(), 'group-chat')
        )
            @include('layouts.nav.footer')
        @endunless
        
        @yield('scripts')
    </div>
</body>
</html>