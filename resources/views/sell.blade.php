@extends('layouts.app')

@section('title', 'Sell on Transamota - Reach Global Buyers')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Sell on Transamota</h1>
            <p class="text-xl max-w-3xl mx-auto">Reach global buyers and grow your business with our comprehensive seller platform</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Start Selling Today</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Join thousands of successful sellers who have transformed their businesses with Transamota</p>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">50K+</div>
                    <div class="text-xl font-medium text-gray-900">Active Sellers</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">180+</div>
                    <div class="text-xl font-medium text-gray-900">Countries Reached</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-4">$5B+</div>
                    <div class="text-xl font-medium text-gray-900">GMV Processed</div>
                </div>
            </div>

            <!-- Value Proposition -->
            <div class="bg-white rounded-xl border border-gray-200 p-8 mb-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Why Sell on Transamota?</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Global Marketplace</h4>
                                    <p class="text-gray-600">Access to buyers in over 180 countries with a single listing</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Verified Buyers</h4>
                                    <p class="text-gray-600">Connect with pre-verified businesses for secure transactions</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Advanced Tools</h4>
                                    <p class="text-gray-600">Product listing tools, analytics, and performance insights</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">24/7 Support</h4>
                                    <p class="text-gray-600">Dedicated seller support team available around the clock</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <img src="/images/why-sell.jpg" alt="Why Sell on Transamota" class="rounded-lg w-full h-auto">
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="mb-16">
                <h3 class="text-3xl font-bold text-gray-900 text-center mb-12">Get Started in 3 Simple Steps</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Create Your Account</h4>
                        <p class="text-gray-600">Sign up as a seller and complete our business verification process</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-blue-600">2</span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">List Your Products</h4>
                        <p class="text-gray-600">Add your products with detailed descriptions, images, and pricing</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-blue-600">3</span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Start Selling</h4>
                        <p class="text-gray-600">Connect with buyers and grow your international business</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-12 text-center text-white">
                <h3 class="text-3xl font-bold mb-6">Ready to Start Selling?</h3>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of successful sellers on Transamota today</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}?type=seller" class="px-8 py-4 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition-colors">
                        Register as Seller
                    </a>
                    <a href="{{ route('how-to-sell') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold hover:bg-white hover:text-blue-600 transition-colors">
                        Learn How to Sell
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection