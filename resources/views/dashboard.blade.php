<x-app-layout>
    <div class="py-6 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section with Current Date/Time -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="mt-1 text-base text-gray-600">Here's what's happening with your requests and services.</p>
                    </div>
                    <div class="mt-2 md:mt-0 text-sm text-gray-500 bg-white px-4 py-2 rounded-md shadow-sm">
                        <p>Current Date: <span class="font-medium">{{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('F j, Y') }}</span></p>
                        <p>Current Time: <span id="live-time" class="font-medium">{{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('g:i:s A') }}</span></p>
                        <script>
                            function updateTime() {
                                const now = new Date();
                                const options = {
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    second: 'numeric',
                                    hour12: true,
                                    timeZone: 'Asia/Manila'
                                };
                                document.getElementById('live-time').textContent = now.toLocaleTimeString('en-US', options);
                            }

                            // Update immediately and then every second
                            updateTime();
                            setInterval(updateTime, 1000);
                        </script>
                    </div>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Pending Requests Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
                    <div class="absolute right-0 top-0 -mt-4 -mr-16 h-24 w-24 rounded-full bg-blue-100 opacity-30"></div>
                    <span class="text-blue-600">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <p class="mt-2 text-sm font-medium text-gray-600">Pending Requests</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $pendingRequests->count() }}</p>
                    <div class="mt-2">
                        <a href="{{ route('requests.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all pending &rarr;</a>
                    </div>
                </div>

                <!-- Processing Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
                    <div class="absolute right-0 top-0 -mt-4 -mr-16 h-24 w-24 rounded-full bg-yellow-100 opacity-30"></div>
                    <span class="text-yellow-500">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </span>
                    <p class="mt-2 text-sm font-medium text-gray-600">Being Processed</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $pendingRequests->where('status', 'processing')->count() }}</p>
                    <div class="mt-2">
                        <a href="{{ route('requests.index', ['status' => 'processing']) }}" class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">View processing &rarr;</a>
                    </div>
                </div>

                <!-- Requires Payment Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
                    <div class="absolute right-0 top-0 -mt-4 -mr-16 h-24 w-24 rounded-full bg-red-100 opacity-30"></div>
                    <span class="text-red-500">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <p class="mt-2 text-sm font-medium text-gray-600">Needs Payment</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $pendingRequests->where('status', 'payment_required')->count() }}</p>
                    <div class="mt-2">
                        <a href="{{ route('requests.index', ['status' => 'payment_required']) }}" class="text-sm text-red-600 hover:text-red-800 font-medium">Pay now &rarr;</a>
                    </div>
                </div>

                <!-- Completed Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
                    <div class="absolute right-0 top-0 -mt-4 -mr-16 h-24 w-24 rounded-full bg-green-100 opacity-30"></div>
                    <span class="text-green-500">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <p class="mt-2 text-sm font-medium text-gray-600">Completed</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $completedRequests->count() }}</p>
                    <div class="mt-2">
                        <a href="{{ route('requests.index', ['status' => 'completed']) }}" class="text-sm text-green-600 hover:text-green-800 font-medium">View history &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Requests Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Active Requests -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-lg font-semibold text-gray-900">Active Requests</h2>
                                <a href="{{ route('requests.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    View All
                                </a>
                            </div>

                            <div class="space-y-5">
                                @forelse($pendingRequests as $request)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                                        <div class="sm:flex sm:items-start sm:justify-between">
                                            <div>
                                                <div class="flex items-center">
                                                    <h3 class="text-base font-medium text-gray-900">{{ $request->service->name }}</h3>
                                                    <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs
                                                        @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($request->status == 'processing') bg-blue-100 text-blue-800
                                                        @elseif($request->status == 'payment_required') bg-red-100 text-red-800
                                                        @elseif($request->status == 'ready_for_pickup') bg-green-100 text-green-800
                                                        @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                    </span>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-500">
                                                    <span class="font-medium">ID:</span> {{ $request->tracking_number }}
                                                </div>
                                                <div class="mt-1 text-sm text-gray-500">
                                                    <span class="font-medium">Submitted:</span> {{ $request->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <div class="mt-3 sm:mt-0 sm:ml-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('requests.show', $request) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                        Details
                                                    </a>
                                                    @if($request->status == 'payment_required')
                                                        <a href="{{ route('payments.show', $request) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                            Pay Now
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Progress Bar -->
                                        @php
                                            $progressPercentage = 0;
                                            if ($request->status == 'pending') {
                                                $progressPercentage = 25;
                                            } elseif ($request->status == 'processing') {
                                                $progressPercentage = 50;
                                            } elseif ($request->status == 'payment_required') {
                                                $progressPercentage = 50;
                                            } elseif ($request->status == 'ready_for_pickup') {
                                                $progressPercentage = 75;
                                            } elseif ($request->status == 'completed') {
                                                $progressPercentage = 100;
                                            }
                                        @endphp

                                        <div class="mt-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage . '%' }}"></div>
                                            </div>
                                            <div class="flex justify-between text-xs text-gray-500">
                                                <span>Submitted</span>
                                                <span>Processing</span>
                                                <span>Ready</span>
                                                <span>Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 bg-gray-50 rounded-lg border border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No active requests</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by requesting a service.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Request a Service
                                            </a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                            </div>

                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @php
                                        $allActivity = collect();

                                        // Add completed requests
                                        foreach($completedRequests as $request) {
                                            $allActivity->push([
                                                'type' => 'request',
                                                'data' => $request,
                                                'date' => $request->updated_at,
                                            ]);
                                        }

                                        // Sort by date descending and take the first 5
                                        $allActivity = $allActivity->sortByDesc('date')->take(5);
                                    @endphp

                                    @forelse($allActivity as $activity)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex items-start space-x-3">
                                                    @if($activity['type'] === 'request')
                                                        <div class="relative">
                                                            <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center ring-8 ring-white">
                                                                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <div>
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $activity['data']->service->name }} Request Completed
                                                                </div>
                                                                <p class="mt-0.5 text-sm text-gray-500">
                                                                    Completed on {{ $activity['date']->format('M d, Y') }}
                                                                </p>
                                                            </div>
                                                            <div class="mt-2 text-sm text-gray-700">
                                                                <p>Your request with tracking number {{ $activity['data']->tracking_number }} has been completed.</p>
                                                                <a href="{{ route('requests.show', $activity['data']) }}" class="mt-1 text-sm font-medium text-blue-600 hover:text-blue-800">
                                                                    View Details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-center py-4 text-gray-500">
                                            No recent activity.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Account Info Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-md font-semibold text-gray-900">Account Status</h3>
                                <p class="text-sm text-gray-600">Last login: {{ now()->format('F j, Y') }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">Username:</span>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2 text-sm">
                                <span class="text-gray-700">Session Status:</span>
                                <span class="font-medium text-green-600">Active</span>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Update Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-lg font-semibold text-gray-900">Notifications</h2>
                                <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    View All
                                </a>
                            </div>

                            <div>
                                @forelse($notifications as $notification)
                                    <div class="mb-3 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }} p-3 rounded-lg border {{ $notification->is_read ? 'border-gray-200' : 'border-blue-200' }}">
                                        <div class="flex justify-between">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h3>
                                            <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($notification->message, 100) }}</p>

                                        @if($notification->request_id)
                                            <div class="mt-2">
                                                <a href="{{ route('requests.show', $notification->request_id) }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                    View Request
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500">
                                        No notifications.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 overflow-hidden shadow-sm sm:rounded-xl text-white">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold mb-5">Quick Actions</h2>

                            <div class="space-y-3">
                                <a href="{{ route('services.index') }}" class="block bg-white bg-opacity-10 hover:bg-opacity-20 transition p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <span>Request a New Service</span>
                                    </div>
                                </a>

                                <a href="{{ route('ordinances.index') }}" class="block bg-white bg-opacity-10 hover:bg-opacity-20 transition p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>View Ordinances</span>
                                    </div>
                                </a>

                                @if (auth()->user()->pendingPayment)
                                    <a href="{{ route('payments.show', ['request' => auth()->user()->pendingPayment->id]) }}" class="block bg-white bg-opacity-10 hover:bg-opacity-20 transition p-4 rounded-lg">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Make a Payment</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Community Updates -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-5">Community Updates</h2>

                            <div class="space-y-4">
                                <div class="p-3 border border-gray-200 rounded-lg">
                                    <h3 class="font-medium text-gray-900">New Water System Update</h3>
                                    <p class="mt-1 text-sm text-gray-600">The municipal water system upgrade will be completed by April 30, 2025.</p>
                                </div>

                                <div class="p-3 border border-gray-200 rounded-lg">
                                    <h3 class="font-medium text-gray-900">Town Hall Meeting</h3>
                                    <p class="mt-1 text-sm text-gray-600">Join us on April 15 for our monthly town hall meeting at the Municipal Hall.</p>
                                </div>

                                <div class="p-3 border border-gray-200 rounded-lg">
                                    <h3 class="font-medium text-gray-900">Holiday Notice</h3>
                                    <p class="mt-1 text-sm text-gray-600">Municipal offices will be closed on April 9 for Araw ng Kagitingan.</p>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    View More Updates
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Completed Requests -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Completed Requests</h2>
                        <a href="{{ route('requests.index', ['status' => 'completed']) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            View All Completed
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Completed</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($completedRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->service->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $request->service->category->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->tracking_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->updated_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('requests.show', $request) }}" class="text-blue-600 hover:text-blue-900">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No completed requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- User Session Info -->
            <div class="mt-8 text-center text-sm text-gray-500 p-4 bg-white rounded-lg shadow-sm">
                <p>
                    <span class="font-medium">Current Session:</span> Logged in as <span class="font-medium">{{ Auth::user()->name }}</span> |
                    Current Date: {{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('F j, Y') }} | Time: <span class="font-medium" id="current-time">{{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('g:i A') }}</span> |
                    @if(Auth::user()->last_login_at)
                        Last login: {{ \Carbon\Carbon::parse(Auth::user()->last_login_at)->setTimezone('Asia/Manila')->format('F j, Y g:i A') }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
