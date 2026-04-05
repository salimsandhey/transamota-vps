<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    @if(isset($categories))
                        @foreach($categories->take(4) as $category)
                            <li><a href="{{ route('products.browse', ['category' => $category->id]) }}" class="hover:text-blue-600">{{ $category->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('products.browse') }}" class="hover:text-blue-600">All Categories</a></li>
                    @endif
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-gray-900 mb-4">More Categories</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    @if(isset($categories))
                        @foreach($categories->skip(4)->take(4) as $category)
                            <li><a href="{{ route('products.browse', ['category' => $category->id]) }}" class="hover:text-blue-600">{{ $category->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('products.browse') }}" class="hover:text-blue-600">All Categories</a></li>
                    @endif
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Sell</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('sell') }}" class="hover:text-blue-600">Sell on Transamota</a></li>
                    <li><a href="{{ route('how-to-sell') }}" class="hover:text-blue-600">How to Sell</a></li>
                    <li><a href="{{ route('business-accounts') }}" class="hover:text-blue-600">Business Accounts</a></li>
                    <li><a href="{{ route('advertise') }}" class="hover:text-blue-600">Advertise</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Help & Support</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('faq') }}" class="hover:text-blue-600">FAQ</a></li>
                    <li><a href="{{ route('safety-tips') }}" class="hover:text-blue-600">Safety Tips</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-600">Contact Us</a></li>
                </ul>
            </div>
            
        </div>
        
        <div class="border-t border-gray-200 mt-8 pt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Transamota. All rights reserved.
        </div>
    </div>
</footer>