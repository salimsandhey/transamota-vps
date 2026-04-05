@extends('buyer.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Personal Information</h2>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            Edit
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <div class="text-gray-900">{{ Auth::user()->name }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <div class="text-gray-900">{{ Auth::user()->email }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <div class="text-gray-900">{{ Auth::user()->phone ?? 'Not provided' }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
            <div class="text-gray-900">{{ Auth::user()->city ?? 'Not provided' }}, {{ Auth::user()->country ?? 'Not provided' }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
            <div class="flex items-center mt-1">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                    <span class="text-gray-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <button class="ml-4 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                    Change
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Form (Hidden by default) -->
<div id="edit-form" class="hidden bg-white rounded-xl border border-gray-200 p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Personal Information</h2>
    
    <form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input type="text" name="city" id="city" value="{{ Auth::user()->city }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" name="country" id="country" value="{{ Auth::user()->country }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                <div class="flex items-center mt-1">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <button class="ml-4 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                        Upload New
                    </button>
                </div>
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