@extends('layouts.app')

@section('title', 'Safety Tips - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Safety Tips</h1>
            <p class="text-xl max-w-3xl mx-auto">Protect yourself and your business with our safety guidelines</p>
        </div>
    </section>

    <!-- Safety Tips Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">General Safety Guidelines</h2>
                    
                    <p class="text-gray-600 mb-6">At Transamota, your safety is our priority. Follow these essential tips to protect yourself and your business when using our platform.</p>
                    
                    <div class="space-y-8">
                        <!-- Tip 1 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">1</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Verify Before You Transact</h3>
                                    <p class="text-gray-600">Always verify the identity of buyers and sellers before proceeding with any transaction. Check their profile, reviews, and verification status. If something seems off, trust your instincts.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tip 2 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">2</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Use Secure Payment Methods</h3>
                                    <p class="text-gray-600">Avoid wire transfers or cash transactions with strangers. Use secure, traceable payment methods that offer buyer and seller protection. Never send money before receiving goods or services.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tip 3 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">3</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Meet in Safe Locations</h3>
                                    <p class="text-gray-600">When meeting in person, choose public, well-lit locations during daylight hours. Avoid meeting at your home or business. Consider bringing a friend or colleague for added security.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tip 4 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">4</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Inspect Items Thoroughly</h3>
                                    <p class="text-gray-600">Carefully inspect any item before purchasing. Test electronics, check for damage, and verify authenticity. If buying a vehicle, consider hiring a professional inspector.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tip 5 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">5</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Keep Records</h3>
                                    <p class="text-gray-600">Maintain records of all transactions, including screenshots of conversations, receipts, and payment confirmations. These can be invaluable if disputes arise.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tip 6 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-blue-600 font-bold">6</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Report Suspicious Activity</h3>
                                    <p class="text-gray-600">If you encounter suspicious behavior, report it immediately using our reporting tools. Include as much detail as possible to help our team investigate and protect other users.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-12">Business Safety Tips</h2>
                    
                    <div class="space-y-8">
                        <!-- Business Tip 1 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-green-600 font-bold">1</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Protect Your Business Information</h3>
                                    <p class="text-gray-600">Be cautious about sharing sensitive business information such as your full business address, financial details, or inventory levels with unverified parties.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Business Tip 2 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-green-600 font-bold">2</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Use Our Verification System</h3>
                                    <p class="text-gray-600">Take advantage of our business verification system to build trust with potential buyers and sellers. Verified businesses are more likely to complete successful transactions.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Business Tip 3 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-green-600 font-bold">3</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Establish Clear Terms</h3>
                                    <p class="text-gray-600">Clearly define terms and conditions for your products or services, including return policies, warranties, and delivery terms. This helps prevent misunderstandings and disputes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg border border-blue-200 p-6 mt-12">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Need Help?</h3>
                        <p class="text-blue-800 mb-4">If you have concerns about a transaction or encounter suspicious activity, don't hesitate to contact our support team immediately.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Contact Support
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection