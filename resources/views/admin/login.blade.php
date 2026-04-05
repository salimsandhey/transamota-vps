@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
            <p class="mt-2 text-sm text-gray-500">Sign in to your admin account</p>
        </div>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</div>
@endsection