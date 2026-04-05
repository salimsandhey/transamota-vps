@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20" style="background: linear-gradient(to top, #00000099), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Frequently Asked Questions</h1>
            <p class="text-xl max-w-3xl mx-auto">Find answers to common questions about our platform and services</p>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How do I register as a buyer or seller?</h3>
                        <p class="text-gray-600">Visit our registration page and select whether you want to register as a buyer or seller. You'll need to provide basic business information and complete our verification process. The verification process typically takes 2-3 business days.</p>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">What are the fees for using Transamota?</h3>
                        <p class="text-gray-600">We offer competitive pricing with different plans for buyers and sellers. Basic listings are free, while premium features require a subscription. Contact our sales team for detailed pricing information tailored to your business needs.</p>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How long does the verification process take?</h3>
                        <p class="text-gray-600">Most verifications are completed within 2-3 business days. The process may take longer during peak periods or if additional documentation is required. You'll receive email notifications at each step of the verification process.</p>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How do I contact customer support?</h3>
                        <p class="text-gray-600">You can reach our support team 24/7 through the contact form on our Contact Us page, by email at support@transamota.com, or by phone at +971 4 123 4567. Our support team typically responds within 24 hours.</p>
                    </div>
                    
                    <!-- FAQ Item 5 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How do I list a product for sale?</h3>
                        <p class="text-gray-600">After registering as a seller and completing verification, log in to your account and navigate to the "Products" section. Click "Create New Product" and fill in the required details including product name, description, price, and images. Your product will be reviewed by our team before going live.</p>
                    </div>
                    
                    <!-- FAQ Item 6 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How do I make a purchase?</h3>
                        <p class="text-gray-600">Browse products on our platform and click on any item to view details. Click "Contact Seller" to initiate a conversation. You can negotiate terms and complete the transaction directly with the seller. Transamota facilitates the connection but does not handle payments directly.</p>
                    </div>
                    
                    <!-- FAQ Item 7 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">What payment methods are accepted?</h3>
                        <p class="text-gray-600">Transamota does not process payments directly. Buyers and sellers negotiate and arrange payment methods directly. We recommend using secure payment methods and following our safety guidelines to protect your transactions.</p>
                    </div>
                    
                    <!-- FAQ Item 8 -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">How can I report a suspicious listing or user?</h3>
                        <p class="text-gray-600">If you encounter a suspicious listing or user, please report it immediately using the "Report" button on the product page or user profile. Our team will investigate and take appropriate action to maintain a safe trading environment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection