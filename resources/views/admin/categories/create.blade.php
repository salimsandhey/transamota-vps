@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Add Category',
                'subtitle' => 'Create a new product category',
                'headerActions' => '<a href="' . route('admin.categories.index') . '" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>'
            ])

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mx-8 mt-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div class="text-green-800 font-medium">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-red-800 font-medium">Please correct the errors below</div>
                        </div>
                        <ul class="mt-2 list-disc pl-5 space-y-1 text-red-600 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Create Category Form -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter category name">
                                @if($errors->has('name'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter category description">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('description') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Icon Selection</label>
                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" id="predefined-icons" name="icon-type" value="predefined" class="mr-2" checked>
                                        <label for="predefined-icons" class="text-sm text-gray-700">Select from predefined icons</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="custom-icon" name="icon-type" value="custom" class="mr-2">
                                        <label for="custom-icon" class="text-sm text-gray-700">Enter custom SVG code</label>
                                    </div>
                                </div>
                                
                                <!-- Predefined Icons Section -->
                                <div id="predefined-icons-section" class="mb-4">
                                    <div class="grid grid-cols-6 gap-4 p-4 border border-gray-200 rounded-lg">
                                        <!-- Electronics Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Electronics</span>
                                        </div>
                                        
                                        <!-- Fashion Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Fashion</span>
                                        </div>
                                        
                                        <!-- Home Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Home</span>
                                        </div>
                                        
                                        <!-- Automotive Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Automotive</span>
                                        </div>
                                        
                                        <!-- Sports Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Sports</span>
                                        </div>
                                        
                                        <!-- Books Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Books</span>
                                        </div>
                                        
                                        <!-- Beauty Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Beauty</span>
                                        </div>
                                        
                                        <!-- Health Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Health</span>
                                        </div>
                                        
                                        <!-- Food Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h6a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h3zm-2 9h10m-5 5v-2" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h6a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h3zm-2 9h10m-5 5v-2" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Food</span>
                                        </div>
                                        
                                        <!-- Toys Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Toys</span>
                                        </div>
                                        
                                        <!-- Office Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Office</span>
                                        </div>
                                        
                                        <!-- Garden Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Garden</span>
                                        </div>
                                        
                                        <!-- Pet Icon -->
                                        <div class="flex flex-col items-center cursor-pointer p-2 rounded hover:bg-gray-100 predefined-icon-option" data-svg='<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'>
                                            <div class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs mt-1">Pet</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Custom Icon Section -->
                                <div id="custom-icon-section" class="hidden">
                                    <textarea 
                                        id="icon" 
                                        name="icon" 
                                        rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono"
                                        placeholder="Enter SVG icon code">{{ old('icon') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Enter SVG code for the category icon (e.g., &lt;svg&gt;...&lt;/svg&gt;)</p>
                                </div>
                                
                                <!-- Hidden input to store selected icon -->
                                <input type="hidden" id="selected-icon" name="icon" value="{{ old('icon') }}">
                                
                                @if($errors->has('icon'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('icon') }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3 pt-4">
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    Create Category
                                </button>
                                
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle radio button changes
    const predefinedRadio = document.getElementById('predefined-icons');
    const customRadio = document.getElementById('custom-icon');
    const predefinedSection = document.getElementById('predefined-icons-section');
    const customSection = document.getElementById('custom-icon-section');
    const selectedIconInput = document.getElementById('selected-icon');
    
    // Set initial state based on radio selection
    if (customRadio.checked) {
        predefinedSection.classList.add('hidden');
        customSection.classList.remove('hidden');
    } else {
        predefinedSection.classList.remove('hidden');
        customSection.classList.add('hidden');
    }
    
    // Handle radio button changes
    predefinedRadio.addEventListener('change', function() {
        if (this.checked) {
            predefinedSection.classList.remove('hidden');
            customSection.classList.add('hidden');
            // Clear custom icon textarea when switching to predefined
            document.getElementById('icon').value = '';
        }
    });
    
    customRadio.addEventListener('change', function() {
        if (this.checked) {
            predefinedSection.classList.add('hidden');
            customSection.classList.remove('hidden');
            // Clear selected icon when switching to custom
            selectedIconInput.value = '';
            // Remove active state from all predefined icons
            document.querySelectorAll('.predefined-icon-option').forEach(icon => {
                icon.classList.remove('bg-blue-100', 'border', 'border-blue-500');
            });
        }
    });
    
    // Handle predefined icon selection
    document.querySelectorAll('.predefined-icon-option').forEach(icon => {
        icon.addEventListener('click', function() {
            // Remove active state from all icons
            document.querySelectorAll('.predefined-icon-option').forEach(i => {
                i.classList.remove('bg-blue-100', 'border', 'border-blue-500');
            });
            
            // Add active state to clicked icon
            this.classList.add('bg-blue-100', 'border', 'border-blue-500');
            
            // Set the selected icon value
            const svgCode = this.getAttribute('data-svg');
            selectedIconInput.value = svgCode;
        });
    });
    
    // Set active state for previously selected icon if editing
    const currentValue = selectedIconInput.value;
    if (currentValue) {
        document.querySelectorAll('.predefined-icon-option').forEach(icon => {
            if (icon.getAttribute('data-svg') === currentValue) {
                icon.classList.add('bg-blue-100', 'border', 'border-blue-500');
            }
        });
    }
});
</script>
@endsection