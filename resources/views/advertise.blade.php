@extends('layouts.app')

@section('title', 'Advertise on Transamota - Promote Your Business')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Advertise on Transamota</h1>
            <p class="text-xl max-w-3xl mx-auto">Reach millions of buyers and sellers with targeted advertising solutions</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Promote Your Business to Global Traders</h2>
                    
                    <p class="text-gray-600 mb-6">Transamota offers powerful advertising solutions that help you reach the right audience at the right time. With millions of active buyers and sellers, our platform provides unmatched visibility for your products and services.</p>
                    
                    <!-- Advertising Solutions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <!-- Product Promotion -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Product Promotion</h3>
                            <p class="text-gray-600 mb-4">Boost your product listings to appear at the top of search results and category pages.</p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>Featured placement in search results</li>
                                <li>Highlighting on category pages</li>
                                <li>Extended visibility for new products</li>
                                <li>Performance tracking and analytics</li>
                            </ul>
                        </div>
                        
                        <!-- Banner Advertising -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Banner Advertising</h3>
                            <p class="text-gray-600 mb-4">Display your brand with eye-catching banner ads across our platform.</p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>Multiple banner sizes and placements</li>
                                <li>Targeted audience segmentation</li>
                                <li>Flexible scheduling options</li>
                                <li>Real-time performance metrics</li>
                            </ul>
                        </div>
                        
                        <!-- Sponsored Categories -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Sponsored Categories</h3>
                            <p class="text-gray-600 mb-4">Prominently feature your brand in specific product categories.</p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>Top placement in category listings</li>
                                <li>Exclusive category sponsorship options</li>
                                <li>Target high-traffic categories</li>
                                <li>Customizable campaign duration</li>
                            </ul>
                        </div>
                        
                        <!-- Email Marketing -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Email Marketing</h3>
                            <p class="text-gray-600 mb-4">Reach engaged buyers directly through targeted email campaigns.</p>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>Targeted subscriber lists</li>
                                <li>Professional email templates</li>
                                <li>A/B testing capabilities</li>
                                <li>Detailed open and click tracking</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Why Advertise With Us -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Why Choose Transamota for Advertising?</h2>
                    
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-2xl font-bold text-blue-600">2M+</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Active Buyers</h4>
                                <p class="text-gray-600">Reach millions of verified business buyers worldwide</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-2xl font-bold text-green-600">180+</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Countries</h4>
                                <p class="text-gray-600">Global reach across continents and markets</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-2xl font-bold text-purple-600">98%</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Satisfaction</h4>
                                <p class="text-gray-600">Advertisers report high satisfaction with results</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Targeting Options -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Precise Targeting Options</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <p class="text-gray-600 mb-4">Our advanced targeting capabilities ensure your ads reach the most relevant audience:</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Industry and product categories</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Geographic location and regions</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Company size and annual revenue</span>
                                </li>
                            </ul>
                            
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Buying behavior and history</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Seasonal and event-based targeting</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Custom audience segments</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Pricing -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Flexible Pricing Options</h2>
                    
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                        <p class="text-gray-600 mb-4">We offer competitive pricing models to fit any budget:</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="border border-gray-200 rounded-lg p-5">
                                <h4 class="text-lg font-bold text-gray-900 mb-3">Pay-Per-Click (PPC)</h4>
                                <p class="text-gray-600 mb-4">Only pay when users click on your ads</p>
                                <ul class="text-sm space-y-2 text-gray-600">
                                    <li>• Set your own daily budget</li>
                                    <li>• Control costs with bid management</li>
                                    <li>• Real-time spending tracking</li>
                                </ul>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-5">
                                <h4 class="text-lg font-bold text-gray-900 mb-3">Cost-Per-Impression</h4>
                                <p class="text-gray-600 mb-4">Pay based on ad views and impressions</p>
                                <ul class="text-sm space-y-2 text-gray-600">
                                    <li>• Guaranteed visibility</li>
                                    <li>• Predictable monthly costs</li>
                                    <li>• Volume discounts available</li>
                                </ul>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-5">
                                <h4 class="text-lg font-bold text-gray-900 mb-3">Fixed-Rate Packages</h4>
                                <p class="text-gray-600 mb-4">Pre-defined packages for specific goals</p>
                                <ul class="text-sm space-y-2 text-gray-600">
                                    <li>• Simplified pricing structure</li>
                                    <li>• Transparent deliverables</li>
                                    <li>• Dedicated account management</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Section -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-8 text-center text-white">
                        <h3 class="text-2xl font-bold mb-4">Ready to Start Advertising?</h3>
                        <p class="text-xl mb-6 max-w-2xl mx-auto">Get in touch with our advertising team to create a campaign that drives results</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('contact') }}?subject=Advertising Inquiry" class="px-6 py-3 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition-colors">
                                Contact Advertising Team
                            </a>
                            <!-- <a href="#" class="px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-bold hover:bg-white hover:text-blue-600 transition-colors">
                                Download Media Kit
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection