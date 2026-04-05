@extends('layouts.app')

@section('title', 'Register - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl border border-gray-200 p-8">
                        <!-- Progress Bar -->
                        @php
                            $step = request('step', 1);
                            $steps = [
                                ['number' => 1, 'title' => 'Basic Info', 'active' => $step == 1, 'completed' => $step > 1],
                                ['number' => 2, 'title' => 'Location', 'active' => $step == 2, 'completed' => $step > 2],
                                ['number' => 3, 'title' => 'Business Details', 'active' => $step == 3, 'completed' => $step > 3],
                            ];
                        @endphp
                        
                        <div class="mb-8">
                            <div class="flex justify-between relative">
                                <!-- Progress line -->
                                <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200 z-0"></div>
                                <div class="absolute top-4 left-0 h-0.5 bg-blue-500 z-10 transition-all duration-300" 
                                     style="width: {{ ($step - 1) * 50 }}%"></div>
                                
                                @foreach($steps as $stepData)
                                    <div class="relative z-20 flex flex-col items-center">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                            @if($stepData['completed']) bg-green-500 text-white
                                            @elseif($stepData['active']) bg-blue-500 text-white
                                            @else bg-gray-200 text-gray-500 @endif">
                                            @if($stepData['completed'])
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-sm font-medium">{{ $stepData['number'] }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-2 text-xs text-center 
                                            @if($stepData['active']) text-blue-600 font-medium 
                                            @else text-gray-500 @endif">
                                            {{ $stepData['title'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="step" value="{{ $step }}">
                            
                            <!-- Step 1: Basic Information -->
                            @if($step == 1)
                                <div id="step-1">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Basic Information</h3>
                                    
                                    <!-- Display general form errors -->
                                    @if ($errors->any())
                                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="text-red-800 font-medium">Please correct the following errors:</div>
                                            </div>
                                            <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <!-- Role Selection -->
                                    <div class="mb-6">
                                        <h4 class="text-md font-medium text-gray-700 mb-3">Select Account Type <span class="text-red-500">*</span></h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="border border-gray-200 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition-colors {{ old('role', session('registration_data.role')) === 'buyer' ? 'border-blue-500 ring-2 ring-blue-100' : '' }}" 
                                                 onclick="selectRole('buyer')">
                                                <input type="radio" name="role" value="buyer" id="role-buyer" class="hidden">
                                                <div class="flex items-center">
                                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">Buyer Account</div>
                                                        <div class="text-sm text-gray-500">For purchasing automotive parts</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="border border-gray-200 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition-colors {{ old('role', session('registration_data.role')) === 'seller' ? 'border-blue-500 ring-2 ring-blue-100' : '' }}" 
                                                 onclick="selectRole('seller')">
                                                <input type="radio" name="role" value="seller" id="role-seller" class="hidden">
                                                <div class="flex items-center">
                                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">Seller Account</div>
                                                        <div class="text-sm text-gray-500">For selling automotive parts</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('role')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @if ($errors->any() && !$errors->has('role') && old('role') === null && session('registration_data.role') === null)
                                            <p class="mt-2 text-sm text-red-600">Please select an account type to continue.</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Personal Information -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', session('registration_data.name')) }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', session('registration_data.email')) }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                            <input type="password" name="password" id="password" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-8 flex justify-end">
                                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors" id="step1-submit">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Step 2: Location Information -->
                            @if($step == 2)
                                <div id="step-2">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Location Information</h3>
                                    
                                    <!-- Display general form errors -->
                                    @if ($errors->any())
                                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="text-red-800 font-medium">Please correct the following errors:</div>
                                            </div>
                                            <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone', session('registration_data.phone')) }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" name="city" id="city" value="{{ old('city', session('registration_data.city')) }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                            <input type="text" name="country" id="country" value="{{ old('country', session('registration_data.country')) }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('country')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mt-8 flex justify-between">
                                        <a href="{{ route('register', ['step' => 1]) }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                            Back
                                        </a>
                                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Step 3: Business Details -->
                            @if($step == 3)
                                <div id="step-3">
                                    @php
                                        $role = session('registration_data.role', old('role'));
                                    @endphp
                                    
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                        {{ $role === 'seller' ? 'Seller Business Details' : 'Buyer Details' }}
                                    </h3>
                                    
                                    <!-- Display general form errors -->
                                    @if ($errors->any())
                                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="text-red-800 font-medium">Please correct the following errors:</div>
                                            </div>
                                            <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <!-- Company Information -->
                                    <div class="mb-6">
                                        <h4 class="text-md font-medium text-gray-700 mb-3">Company Information</h4>
                                        <div>
                                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name (Optional)</label>
                                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('company_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Role-Specific Fields -->
                                    @if($role === 'seller')
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium text-gray-700 mb-3">Business Information</h4>
                                            <div class="grid grid-cols-1 gap-6">
                                                <div>
                                                    <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
                                                    <select name="business_type" id="business_type" 
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                        <option value="">Select business type</option>
                                                        <option value="manufacturer" {{ old('business_type') === 'manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                                                        <option value="distributor" {{ old('business_type') === 'distributor' ? 'selected' : '' }}>Distributor</option>
                                                        <option value="retailer" {{ old('business_type') === 'retailer' ? 'selected' : '' }}>Retailer</option>
                                                        <option value="wholesaler" {{ old('business_type') === 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                                        <option value="oem" {{ old('business_type') === 'oem' ? 'selected' : '' }}>OEM</option>
                                                    </select>
                                                    @error('business_type')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label for="products_offered" class="block text-sm font-medium text-gray-700 mb-1">Products Offered</label>
                                                    <textarea name="products_offered" id="products_offered" rows="3" 
                                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                                              placeholder="Describe the automotive parts you sell..." required>{{ old('products_offered') }}</textarea>
                                                    @error('products_offered')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website (Optional)</label>
                                                        <input type="url" name="website" id="website" value="{{ old('website') }}" 
                                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                               placeholder="https://example.com">
                                                        @error('website')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div>
                                                        <label for="gst_no" class="block text-sm font-medium text-gray-700 mb-1">GST Number (Optional)</label>
                                                        <input type="text" name="gst_no" id="gst_no" value="{{ old('gst_no') }}" 
                                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        @error('gst_no')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium text-gray-700 mb-3">Buyer Information</h4>
                                            <div class="grid grid-cols-1 gap-6">
                                                <div>
                                                    <label for="products_interested" class="block text-sm font-medium text-gray-700 mb-1">Products Interested In</label>
                                                    <textarea name="products_interested" id="products_interested" rows="3" 
                                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                                              placeholder="Describe the automotive parts you're interested in buying..." required>{{ old('products_interested') }}</textarea>
                                                    @error('products_interested')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label for="buying_frequency" class="block text-sm font-medium text-gray-700 mb-1">Buying Frequency</label>
                                                    <select name="buying_frequency" id="buying_frequency" 
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                        <option value="">Select frequency</option>
                                                        <option value="weekly" {{ old('buying_frequency') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                        <option value="monthly" {{ old('buying_frequency') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                        <option value="quarterly" {{ old('buying_frequency') === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                        <option value="yearly" {{ old('buying_frequency') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                                        <option value="occasional" {{ old('buying_frequency') === 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    </select>
                                                    @error('buying_frequency')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Terms and Submit -->
                                    <div class="border-t border-gray-200 pt-6">
                                        <div class="flex items-center mb-4">
                                            <input type="checkbox" name="terms" id="terms" class="rounded text-blue-600 focus:ring-blue-500" required>
                                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                                            </label>
                                        </div>
                                        @error('terms')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        
                                        <div class="flex justify-between">
                                            <a href="{{ route('register', ['step' => 2]) }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                                Back
                                            </a>
                                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                                Register Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                        
                        @if($step == 1)
                            <div class="mt-6 text-center text-sm text-gray-600">
                                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Sign in</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        // Update radio button selection
        document.getElementById('role-' + role).checked = true;
        
        // Update visual selection
        const buyerCard = document.querySelector('[onclick="selectRole(\'buyer\')"]');
        const sellerCard = document.querySelector('[onclick="selectRole(\'seller\')"]');
        
        if (role === 'buyer') {
            buyerCard.classList.add('border-blue-500', 'ring-2', 'ring-blue-100');
            buyerCard.classList.remove('border-gray-200');
            sellerCard.classList.remove('border-blue-500', 'ring-2', 'ring-blue-100');
            sellerCard.classList.add('border-gray-200');
        } else {
            sellerCard.classList.add('border-blue-500', 'ring-2', 'ring-blue-100');
            sellerCard.classList.remove('border-gray-200');
            buyerCard.classList.remove('border-blue-500', 'ring-2', 'ring-blue-100');
            buyerCard.classList.add('border-gray-200');
        }
        
        // Remove any existing error message when a role is selected
        const errorDiv = document.querySelector('.role-error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        
        // Reset submit button if it was in error state
        const submitButton = document.getElementById('step1-submit');
        if (submitButton) {
            submitButton.classList.remove('bg-red-600', 'hover:bg-red-700');
            submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
            submitButton.textContent = 'Continue';
        }
    }
    
    // Add form validation before submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Check if we're on step 1
                const step1 = document.getElementById('step-1');
                if (step1) {
                    const roleSelected = document.querySelector('input[name="role"]:checked');
                    const submitButton = document.getElementById('step1-submit');
                    
                    if (!roleSelected) {
                        e.preventDefault();
                        
                        // Show error message
                        let errorDiv = document.querySelector('.role-error-message');
                        if (!errorDiv) {
                            errorDiv = document.createElement('p');
                            errorDiv.className = 'mt-2 text-sm text-red-600 role-error-message';
                            errorDiv.textContent = 'Please select an account type to continue.';
                            
                            // Insert after the role selection div
                            const roleDiv = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.gap-4').parentNode;
                            roleDiv.parentNode.insertBefore(errorDiv, roleDiv.nextSibling);
                        }
                        
                        // Highlight the submit button
                        if (submitButton) {
                            submitButton.classList.add('bg-red-600', 'hover:bg-red-700');
                            submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                            submitButton.textContent = 'Please Select Account Type';
                        }
                        
                        // Scroll to the error
                        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        return false;
                    }
                }
            });
        }
    });
</script>
@endsection