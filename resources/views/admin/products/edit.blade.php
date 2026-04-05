@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Edit Product',
                'subtitle' => 'Modify product details',
                'headerActions' => '<a href="' . route('admin.products.index') . '" class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>'
            ])

            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₹)</label>
                                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
                                    <select name="subcategory_id" id="subcategory_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select a subcategory</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="moq" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Quantity</label>
                                    <input type="number" name="moq" id="moq" min="1" value="{{ old('moq', $product->moq) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('moq')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="origin_country" class="block text-sm font-medium text-gray-700 mb-1">Origin Country</label>
                                    <input type="text" name="origin_country" id="origin_country" value="{{ old('origin_country', $product->origin_country) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('origin_country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="verification_status" class="block text-sm font-medium text-gray-700 mb-1">Verification Status</label>
                                    <select name="verification_status" id="verification_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending" {{ old('verification_status', $product->verification_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('verification_status', $product->verification_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('verification_status', $product->verification_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('verification_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Visibility Status</label>
                                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    Cancel
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const subcategorySelect = document.getElementById('subcategory_id');
    
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        
        // Clear subcategory options
        subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
        
        if (categoryId) {
            // In a real application, you would fetch subcategories via AJAX
            // For now, we'll just show a message
            subcategorySelect.innerHTML += '<option value="">Please select a category first</option>';
        }
    });
});
</script>
@endsection