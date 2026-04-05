@extends('seller.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Account Settings</h2>
        <p class="text-gray-500">Manage your account preferences and security settings</p>
    </div>
    
    <form action="{{ route('seller.profile.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Notification Preferences -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Notification Preferences</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Email Notifications</div>
                        <div class="text-sm text-gray-500">Receive email updates about your account</div>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" name="email_notifications" id="email_notifications" class="sr-only" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                        <label for="email_notifications" class="block h-6 w-10 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ Auth::user()->email_notifications ? 'bg-blue-600' : '' }}">
                            <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 ease-in-out {{ Auth::user()->email_notifications ? 'transform translate-x-4' : '' }}"></span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Order Notifications</div>
                        <div class="text-sm text-gray-500">Receive notifications about new orders</div>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" name="order_notifications" id="order_notifications" class="sr-only" {{ Auth::user()->order_notifications ? 'checked' : '' }}>
                        <label for="order_notifications" class="block h-6 w-10 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ Auth::user()->order_notifications ? 'bg-blue-600' : '' }}">
                            <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 ease-in-out {{ Auth::user()->order_notifications ? 'transform translate-x-4' : '' }}"></span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Product Notifications</div>
                        <div class="text-sm text-gray-500">Receive notifications about product updates</div>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" name="product_notifications" id="product_notifications" class="sr-only" {{ Auth::user()->product_notifications ? 'checked' : '' }}>
                        <label for="product_notifications" class="block h-6 w-10 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ Auth::user()->product_notifications ? 'bg-blue-600' : '' }}">
                            <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 ease-in-out {{ Auth::user()->product_notifications ? 'transform translate-x-4' : '' }}"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Security Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Security Settings</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <button type="reset" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Reset</button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
        </div>
    </form>
</div>

<script>
    // Toggle switch functionality
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const span = label.querySelector('span');
            
            if (this.checked) {
                label.classList.add('bg-blue-600');
                span.classList.add('transform', 'translate-x-4');
            } else {
                label.classList.remove('bg-blue-600');
                span.classList.remove('transform', 'translate-x-4');
            }
        });
    });
</script>
@endsection