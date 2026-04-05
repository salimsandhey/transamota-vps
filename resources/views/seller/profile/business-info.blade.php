@extends('seller.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Business Information</h2>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            Edit
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
            <div class="text-gray-900">{{ Auth::user()->company_name ?? 'Not provided' }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
            <div class="text-gray-900">{{ Auth::user()->profile->business_type ?? 'Not provided' }}</div>
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Products Offered</label>
            <div class="text-gray-900">{{ Auth::user()->profile->products_offered ?? 'Not provided' }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
            <div class="text-gray-900">{{ Auth::user()->profile->gst_no ?? 'Not provided' }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
            <div class="text-gray-900">{{ Auth::user()->profile->website ?? 'Not provided' }}</div>
        </div>
    </div>
</div>

<!-- Edit Form (Hidden by default) -->
<div id="edit-form" class="hidden bg-white rounded-xl border border-gray-200 p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Business Information</h2>
    
    <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <input type="text" name="company_name" id="company_name" value="{{ Auth::user()->company_name }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
                <select name="business_type" id="business_type" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select business type</option>
                    <option value="manufacturer" {{ Auth::user()->profile->business_type === 'manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                    <option value="distributor" {{ Auth::user()->profile->business_type === 'distributor' ? 'selected' : '' }}>Distributor</option>
                    <option value="retailer" {{ Auth::user()->profile->business_type === 'retailer' ? 'selected' : '' }}>Retailer</option>
                    <option value="wholesaler" {{ Auth::user()->profile->business_type === 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                    <option value="oem" {{ Auth::user()->profile->business_type === 'oem' ? 'selected' : '' }}>OEM</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label for="products_offered" class="block text-sm font-medium text-gray-700 mb-1">Products Offered</label>
                <textarea name="products_offered" id="products_offered" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ Auth::user()->profile->products_offered }}</textarea>
            </div>
            
            <div>
                <label for="gst_no" class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                <input type="text" name="gst_no" id="gst_no" value="{{ Auth::user()->profile->gst_no }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="url" name="website" id="website" value="{{ Auth::user()->profile->website }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-8">
            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.querySelector('.flex.items-center.justify-between.mb-6 button');
        const editForm = document.getElementById('edit-form');
        const cancelButton = editForm.querySelector('button[type="button"]');
        
        editButton.addEventListener('click', function() {
            editForm.classList.toggle('hidden');
        });
        
        cancelButton.addEventListener('click', function() {
            editForm.classList.add('hidden');
        });
    });
</script>
@endsection