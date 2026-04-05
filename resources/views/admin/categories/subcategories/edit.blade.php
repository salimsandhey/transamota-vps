@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Edit Subcategory',
                'subtitle' => 'Update subcategory information',
                'headerActions' => '<a href="' . route('admin.categories.subcategories.index', $category) . '" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Subcategories
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

            <!-- Edit Subcategory Form -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <form method="POST" action="{{ route('admin.categories.subcategories.update', [$category, $subcategory]) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Subcategory Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $subcategory->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter subcategory name">
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
                                    placeholder="Enter subcategory description">{{ old('description', $subcategory->description) }}</textarea>
                                @if($errors->has('description'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('description') }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3 pt-4">
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    Update Subcategory
                                </button>
                                
                                <a href="{{ route('admin.categories.subcategories.index', $category) }}" 
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
@endsection