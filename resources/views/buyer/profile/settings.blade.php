@extends('buyer.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Account Settings</h2>
    
    <div class="space-y-6">
        <!-- Notification Preferences -->
        <div>
            <h3 class="text-md font-medium text-gray-700 mb-3">Notification Preferences</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Email Notifications</div>
                        <div class="text-sm text-gray-500">Receive email updates about your account</div>
                    </div>
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600" role="switch" aria-checked="true">
                        <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5">
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-5.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                </svg>
                            </span>
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2M3 3l1 1m4 8l-4-4m0 0l-1-1m1 1l4 4" />
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Order Updates</div>
                        <div class="text-sm text-gray-500">Get notified about order status changes</div>
                    </div>
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600" role="switch" aria-checked="true">
                        <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5">
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-5.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                </svg>
                            </span>
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2M3 3l1 1m4 8l-4-4m0 0l-1-1m1 1l4 4" />
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Product Recommendations</div>
                        <div class="text-sm text-gray-500">Receive suggestions based on your interests</div>
                    </div>
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200" role="switch" aria-checked="false">
                        <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0">
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2M3 3l1 1m4 8l-4-4m0 0l-1-1m1 1l4 4" />
                                </svg>
                            </span>
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-5.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Privacy Settings -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-md font-medium text-gray-700 mb-3">Privacy Settings</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">Profile Visibility</div>
                        <div class="text-sm text-gray-500">Make your profile visible to other users</div>
                    </div>
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600" role="switch" aria-checked="true">
                        <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5">
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-5.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                </svg>
                            </span>
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 ease-in duration-100" aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2M3 3l1 1m4 8l-4-4m0 0l-1-1m1 1l4 4" />
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Security Settings -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-md font-medium text-gray-700 mb-3">Security</h3>
            <div class="space-y-3">
                <div>
                    <a href="#" class="flex items-center justify-between py-3">
                        <div>
                            <div class="font-medium text-gray-900">Change Password</div>
                            <div class="text-sm text-gray-500">Update your password regularly</div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div>
                    <a href="#" class="flex items-center justify-between py-3">
                        <div>
                            <div class="font-medium text-gray-900">Two-Factor Authentication</div>
                            <div class="text-sm text-gray-500">Add an extra layer of security</div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 mr-2">Off</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                </div>
                
                <div>
                    <a href="#" class="flex items-center justify-between py-3">
                        <div>
                            <div class="font-medium text-gray-900">Active Sessions</div>
                            <div class="text-sm text-gray-500">View and manage your sessions</div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Danger Zone -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-md font-medium text-gray-700 mb-3">Danger Zone</h3>
            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Delete Account</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Once you delete your account, all your data will be permanently removed. This action cannot be undone.</p>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection