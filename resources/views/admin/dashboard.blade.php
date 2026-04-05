@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Stats Grid -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @php
                        $stats = [
                            ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Total Users', 'value' => number_format($totalUsers), 'change' => $userGrowth . '% vs last period', 'positive' => true],
                            ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Total Products', 'value' => number_format($totalProducts), 'change' => $productGrowth . '% vs last period', 'positive' => true],
                            ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Pending Products', 'value' => number_format($pendingProducts), 'change' => '', 'positive' => false],
                            ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'label' => 'Revenue', 'value' => $totalRevenue, 'change' => 'from approved products', 'positive' => true]
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 {{ $stat['label'] == 'Total Users' ? 'text-blue-500' : ($stat['label'] == 'Total Products' ? 'text-green-500' : ($stat['label'] == 'Pending Products' ? 'text-amber-500' : 'text-purple-500')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $stat['label'] }}</span>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-gray-800 mb-2">{{ $stat['value'] }}</div>
                            @if(!empty($stat['change']))
                                <div class="text-xs {{ $stat['positive'] ? 'text-green-600' : 'text-red-600' }} flex items-center gap-1">
                                    <span>{{ $stat['positive'] ? '▲' : '▼' }}</span>
                                    <span>{{ $stat['change'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Pending Verification Notification -->
                @if($pendingUsers > 0)
                <div class="mb-8">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-amber-800">Pending User Verification</h3>
                                <div class="mt-2 text-amber-700">
                                    <p>Review and verify seller documents and approve buyer accounts.</p>
                                    <a href="{{ route('admin.verifications.users.index') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-amber-800 bg-amber-100 hover:bg-amber-200">
                                        Review Pending Verifications
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Recent Activity and System Status --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    {{-- Recent Activity --}}
                    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Recent Activity</h3>
                                <div class="text-2xl font-bold text-gray-800">Latest Updates</div>
                            </div>
                            <div class="flex items-center gap-2" id="activity-filters">
                                <button class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-800 filter-btn active" data-filter="all">All</button>
                                <button class="px-3 py-1 text-xs rounded text-gray-500 hover:bg-gray-50 filter-btn" data-filter="user">Users</button>
                                <button class="px-3 py-1 text-xs rounded text-gray-500 hover:bg-gray-50 filter-btn" data-filter="product">Products</button>
                            </div>
                        </div>
                        <div class="space-y-4" id="activity-list">
                            @php
                                // Combine recent users and products and sort by created_at
                                $activities = collect();
                                
                                // Add recent user registrations
                                foreach($recentUsers as $user) {
                                    $activities->push([
                                        'type' => 'user',
                                        'title' => 'New user registered',
                                        'description' => $user->name . ' registered as a new ' . $user->role,
                                        'time' => $user->created_at->diffForHumans(),
                                        'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                        'icon_color' => 'blue',
                                        'badge' => 'New',
                                        'badge_color' => 'green'
                                    ]);
                                }
                                
                                // Add recent product additions
                                foreach($recentProducts as $product) {
                                    $activities->push([
                                        'type' => 'product',
                                        'title' => 'New product added',
                                        'description' => $product->name . ' added by ' . ($product->seller ? $product->seller->name : 'Unknown Seller'),
                                        'time' => $product->created_at->diffForHumans(),
                                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                                        'icon_color' => 'green',
                                        'badge' => 'Pending',
                                        'badge_color' => $product->verification_status == 'approved' ? 'green' : ($product->verification_status == 'rejected' ? 'red' : 'amber')
                                    ]);
                                }
                                
                                // Sort by time (most recent first)
                                $activities = $activities->sortByDesc(function($activity) {
                                    return $activity['time'];
                                })->values()->take(10);
                            @endphp
                            
                            @foreach($activities as $activity)
                                <div class="flex items-start gap-4 p-4 hover:bg-gray-50 rounded-lg transition-colors" data-type="{{ $activity['type'] }}">
                                    <div class="w-10 h-10 bg-{{ $activity['icon_color'] }}-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-{{ $activity['icon_color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity['icon'] }}"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">{{ $activity['title'] }}</div>
                                        <div class="text-sm text-gray-600">{{ $activity['description'] }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</div>
                                    </div>
                                    <span class="px-2 py-1 bg-{{ $activity['badge_color'] }}-100 text-{{ $activity['badge_color'] }}-800 text-xs rounded-full">
                                        {{ $activity['badge'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- System Status --}}
                    <!-- <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-medium text-gray-800">System Status</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 {{ $systemStatus['database'] == 'operational' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 {{ $systemStatus['database'] == 'operational' ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-800">Database</span>
                                </div>
                                <span class="text-xs {{ $systemStatus['database'] == 'operational' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($systemStatus['database']) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 {{ $systemStatus['web_server'] == 'operational' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 {{ $systemStatus['web_server'] == 'operational' ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-800">Web Server</span>
                                </div>
                                <span class="text-xs {{ $systemStatus['web_server'] == 'operational' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($systemStatus['web_server']) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 {{ $systemStatus['api'] == 'operational' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 {{ $systemStatus['api'] == 'operational' ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-800">API</span>
                                </div>
                                <span class="text-xs {{ $systemStatus['api'] == 'operational' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($systemStatus['api']) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 {{ $systemStatus['email_service'] == 'operational' ? 'bg-green-50' : ($systemStatus['email_service'] == 'degraded' ? 'bg-amber-50' : 'bg-red-50') }} rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 {{ $systemStatus['email_service'] == 'operational' ? 'bg-green-500' : ($systemStatus['email_service'] == 'degraded' ? 'bg-amber-500' : 'bg-red-500') }} rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-800">Email Service</span>
                                </div>
                                <span class="text-xs {{ $systemStatus['email_service'] == 'operational' ? 'text-green-600' : ($systemStatus['email_service'] == 'degraded' ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ ucfirst($systemStatus['email_service']) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 {{ $systemStatus['payment_gateway'] == 'operational' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 {{ $systemStatus['payment_gateway'] == 'operational' ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-800">Payment Gateway</span>
                                </div>
                                <span class="text-xs {{ $systemStatus['payment_gateway'] == 'operational' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($systemStatus['payment_gateway']) }}
                                </span>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Recent User Registrations -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-medium text-gray-800">Recent User Registrations</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All Users</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">User</th>
                                    <th class="pb-3 font-medium">Role</th>
                                    <th class="pb-3 font-medium">Registration Date</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($recentUsers as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <span class="text-gray-600 text-sm font-medium">
                                                        {{ substr($user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-800 text-sm">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-sm text-gray-600">{{ ucfirst($user->role) }}</td>
                                        <td class="py-4 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="py-4">
                                            <span class="px-2 py-1 {{ $user->is_verified ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }} text-xs rounded-full">
                                                {{ $user->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="py-4">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const activityItems = document.querySelectorAll('#activity-list > div');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-gray-100', 'text-gray-800'));
                    
                    // Add active class to clicked button
                    this.classList.add('active', 'bg-gray-100', 'text-gray-800');
                    
                    // Remove hover classes from other buttons
                    filterButtons.forEach(btn => {
                        if (!btn.classList.contains('active')) {
                            btn.classList.remove('bg-gray-100', 'text-gray-800');
                            btn.classList.add('text-gray-500', 'hover:bg-gray-50');
                        }
                    });
                    
                    const filter = this.getAttribute('data-filter');
                    
                    // Filter activity items
                    activityItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-type') === filter) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection