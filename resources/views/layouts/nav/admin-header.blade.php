<nav class="bg-white shadow sticky top-0">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-xl font-bold text-gray-900">Admin Panel</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        @if(Auth::check())
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                Login
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>