@extends('layouts.app')

@section('title', 'Business with Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Business with Transamota</h1>
            <p class="text-xl max-w-3xl mx-auto">Join our global B2B marketplace and unlock new opportunities for growth</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Grow Your Business Globally</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Transamota connects buyers and sellers worldwide, providing the tools and network you need to expand your business internationally.</p>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">10K+</div>
                    <div class="text-xl font-medium text-gray-900">Businesses Connected</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">50+</div>
                    <div class="text-xl font-medium text-gray-900">Countries Served</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">$2B+</div>
                    <div class="text-xl font-medium text-gray-900">Transactions Facilitated</div>
                </div>
            </div>

            <!-- Value Proposition -->
            <div class="bg-white rounded-xl border border-gray-200 p-8 mb-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Why Choose Transamota?</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Global Reach</h4>
                                    <p class="text-gray-600">Access to buyers and sellers in over 50 countries worldwide</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Verified Network</h4>
                                    <p class="text-gray-600">All members go through rigorous verification processes</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Secure Transactions</h4>
                                    <p class="text-gray-600">Bank-level security and escrow services for all transactions</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">24/7 Support</h4>
                                    <p class="text-gray-600">Dedicated support team available around the clock</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Join Options -->
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900 mb-6">Join Transamota Today</h3>
                <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">Choose the option that best fits your business needs</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Join as Buyer -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4">Join as Buyer</h4>
                        <p class="text-gray-600 mb-8">Find verified suppliers, compare products, and streamline your procurement process.</p>
                        <a href="{{ route('register') }}?type=buyer" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors inline-block">
                            Register as Buyer
                        </a>
                        <ul class="mt-6 space-y-2 text-left text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Access to thousands of verified suppliers
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Competitive pricing and bulk discounts
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Secure payment and delivery options
                            </li>
                        </ul>
                    </div>

                    <!-- Join as Seller -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4">Join as Seller</h4>
                        <p class="text-gray-600 mb-8">Reach global buyers and grow your business with our comprehensive seller tools.</p>
                        <a href="{{ route('register') }}?type=seller" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors inline-block">
                            Register as Seller
                        </a>
                        <ul class="mt-6 space-y-2 text-left text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Global marketplace exposure
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Advanced product listing tools
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Analytics and performance insights
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="bg-gray-50 rounded-xl p-8 mb-16">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Success Stories</h3>
                    <p class="text-gray-600">Hear from businesses that have transformed their operations with Transamota</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                            <div>
                                <div class="font-medium text-gray-900">Sarah Johnson</div>
                                <div class="text-sm text-gray-500">Procurement Manager, TechGlobal Inc.</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"Transamota has revolutionized our procurement process. We've found reliable suppliers in 15 new countries, reducing costs by 25%."</p>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                            <div>
                                <div class="font-medium text-gray-900">Michael Chen</div>
                                <div class="text-sm text-gray-500">Export Director, Shenzhen Electronics</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"Since joining Transamota, our international sales have increased by 180%. The platform's verification system builds trust with buyers."</p>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                            <div>
                                <div class="font-medium text-gray-900">Emma Rodriguez</div>
                                <div class="text-sm text-gray-500">CEO, Premium Textiles Ltd.</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"The digital trade fairs feature helped us connect with buyers during the pandemic when physical trade shows weren't possible."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection