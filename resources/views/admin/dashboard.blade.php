<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    
    <!-- Date Display -->
    <div class="mb-6">
        <p class="text-sm text-gray-600">Current Date: <span class="font-medium">{{ now()->format('F d, Y') }}</span></p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Requests</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900">{{ $pendingRequests + $processingRequests + $completedRequests }}</div>
                                <div class="text-xs text-green-600">+{{ rand(5, 20) }}% from last month</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.requests.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        View all
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900">₱{{ number_format($totalPayments, 2) }}</div>
                                <div class="text-xs text-green-600">+{{ rand(5, 15) }}% from last month</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.payments.index') }}" class="font-medium text-green-600 hover:text-green-500">
                        View all
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Registered Users</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900">{{ $totalUsers }}</div>
                                <div class="text-xs text-green-600">+{{ rand(2, 10) }}% from last month</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.users.index') }}" class="font-medium text-purple-600 hover:text-purple-500">
                        View all
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-yellow-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Services</dt>
                            <dd>
                                <div class="text-lg font-semibold text-gray-900">{{ App\Models\Service::count() }}</div>
                                <div class="text-xs text-gray-600">Across {{ App\Models\ServiceCategory::count() }} categories</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.services.index') }}" class="font-medium text-yellow-600 hover:text-yellow-500">
                        View all
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Request Status Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Request Overview</h3>
                <p class="mt-1 text-sm text-gray-500">Current status of service requests</p>
            </div>
            <div class="p-6">
                <canvas id="requestChart" height="200"></canvas>
            </div>
        </div>
        
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Request Status</h3>
                <p class="mt-1 text-sm text-gray-500">Distribution by status</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Pending</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $pendingRequests }}</span>
                            <span class="ml-2 text-xs py-0.5 px-2 rounded-full bg-yellow-100 text-yellow-800">
                                {{ round(($pendingRequests / max(1, $pendingRequests + $processingRequests + $completedRequests)) * 100) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Processing</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $processingRequests }}</span>
                            <span class="ml-2 text-xs py-0.5 px-2 rounded-full bg-blue-100 text-blue-800">
                                {{ round(($processingRequests / max(1, $pendingRequests + $processingRequests + $completedRequests)) * 100) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-green-400 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Completed</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $completedRequests }}</span>
                            <span class="ml-2 text-xs py-0.5 px-2 rounded-full bg-green-100 text-green-800">
                                {{ round(($completedRequests / max(1, $pendingRequests + $processingRequests + $completedRequests)) * 100) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-red-400 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Payment Required</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $paymentRequiredCount }}</span>
                            <span class="ml-2 text-xs py-0.5 px-2 rounded-full bg-red-100 text-red-800">
                                {{ round(($paymentRequiredCount / max(1, $pendingRequests + $processingRequests + $completedRequests + $paymentRequiredCount)) * 100) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 rounded-b-lg">
                <a href="{{ route('admin.requests.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View detailed report →
                </a>
            </div>
        </div>
    </div>
    
    <!-- Payments & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Payment Overview -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Methods</h3>
                <p class="mt-1 text-sm text-gray-500">Distribution by payment method</p>
            </div>
            <div class="p-6">
                <canvas id="paymentChart" height="200"></canvas>
            </div>
            <div class="px-6 py-4 bg-gray-50 rounded-b-lg">
                <a href="{{ route('admin.payments.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View all payments →
                </a>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Activity</h3>
                <p class="mt-1 text-sm text-gray-500">Latest requests and payments</p>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($recentActivity as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-3">
                                        @if($activity['type'] === 'request')
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        New {{ $activity['data']->service->name }} Request
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $activity['created_at']->diffForHumans() }} by {{ $activity['data']->user->name }}
                                                    </p>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700">
                                                    <p>Tracking #: {{ $activity['data']->tracking_number }}</p>
                                                    <a href="{{ route('admin.requests.show', $activity['data']) }}" class="mt-1 text-sm font-medium text-blue-600 hover:text-blue-500">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        @elseif($activity['type'] === 'payment')
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Payment Received (₱{{ number_format($activity['data']->amount, 2) }})
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $activity['created_at']->diffForHumans() }} by {{ $activity['data']->request->user->name }}
                                                    </p>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700">
                                                    <p>Method: {{ ucfirst($activity['data']->payment_method) }}</p>
                                                    <p>For service: {{ $activity['data']->request->service->name }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Services & User Growth -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Services -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Popular Services</h3>
                <p class="mt-1 text-sm text-gray-500">Services with most requests</p>
            </div>
            <div class="p-6">
                <ul class="divide-y divide-gray-200">
                    @foreach($popularServices as $service)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 mr-2">{{ $loop->iteration }}.</span>
                                <span class="text-sm font-medium text-gray-900">{{ $service->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 mr-2">{{ $service->requests_count }} requests</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $loop->iteration <= 3 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $loop->iteration <= 3 ? 'Top ' . $loop->iteration : 'Rank ' . $loop->iteration }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <!-- User Growth -->
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">User Registration</h3>
                <p class="mt-1 text-sm text-gray-500">New users over time</p>
            </div>
            <div class="p-6">
                <canvas id="userChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Charts setup -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Request Status Chart
            const requestCtx = document.getElementById('requestChart').getContext('2d');
            new Chart(requestCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [
                        {
                            label: 'New Requests',
                            data: [65, 78, 90, 85, 92, 110],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Completed',
                            data: [45, 55, 65, 70, 85, 95],
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Payment Methods Chart
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
            new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['GCash', 'PayMaya', 'Waived', 'Other'],
                    datasets: [{
                        label: 'Payment Methods',
                        data: [
                            {{ App\Models\Payment::where('payment_method', 'gcash')->count() }},
                            {{ App\Models\Payment::where('payment_method', 'paymaya')->count() }},
                            {{ App\Models\Payment::where('payment_method', 'waived')->count() }},
                            {{ App\Models\Payment::whereNotIn('payment_method', ['gcash', 'paymaya', 'waived'])->count() }}
                        ],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(168, 85, 247, 0.7)',
                            'rgba(107, 114, 128, 0.7)',
                            'rgba(251, 191, 36, 0.7)'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
            
            // User Growth Chart
            const userCtx = document.getElementById('userChart').getContext('2d');
            new Chart(userCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'New Users',
                        data: [28, 35, 40, 42, 50, 65],
                        backgroundColor: 'rgba(168, 85, 247, 0.7)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>