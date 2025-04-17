<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <form action="{{ route('admin.search') }}" method="GET">
                <label for="global-search" class="block text-sm font-medium text-gray-700 mb-2">Search Again</label>
                <div class="flex">
                    <div class="relative flex-grow">
                        <input type="text" name="query" id="global-search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search for users, requests, services, ordinances..." value="{{ $query }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Results for "{{ $query }}"</h3>
            
            @if($users->isEmpty() && $requests->isEmpty() && $services->isEmpty() && $ordinances->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No results found</h3>
                    <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                </div>
            @else
                <!-- Users Section -->
                @if($users->isNotEmpty())
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Users</h4>
                        <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-white">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                                <th scope="col" class="relative px-4 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($users as $user)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'staff' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                            {{ ucfirst($user->role) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($users->count() >= 5)
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('admin.users.index', ['search' => $query]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            View all user results
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Requests Section -->
                @if($requests->isNotEmpty())
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Service Requests</h4>
                        <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-white">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="relative px-4 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($requests as $request)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ $request->tracking_number }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $request->service->name ?? 'N/A' }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $request->user->name ?? 'N/A' }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                                            @elseif($request->status == 'processing') bg-blue-100 text-blue-800
                                                            @elseif($request->status == 'payment_required') bg-red-100 text-red-800
                                                            @elseif($request->status == 'ready_for_pickup') bg-purple-100 text-purple-800
                                                            @elseif($request->status == 'completed') bg-green-100 text-green-800
                                                            @elseif($request->status == 'rejected') bg-gray-100 text-gray-800
                                                            @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('admin.requests.show', $request) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($requests->count() >= 5)
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('admin.requests.index', ['search' => $query]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            View all request results
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Services Section -->
                @if($services->isNotEmpty())
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Services</h4>
                        <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($services as $service)
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
                                            <div class="p-4">
                                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $service->name }}</h4>
                                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $service->description }}</p>
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm text-gray-900 font-medium">₱{{ number_format($service->fee, 2) }}</span>
                                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-sm text-blue-600 hover:text-blue-800">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($services->count() >= 5)
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('admin.services.index', ['search' => $query]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            View all service results
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Ordinances Section -->
                @if($ordinances->isNotEmpty())
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Ordinances</h4>
                        <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4">
                                <div class="divide-y divide-gray-200">
                                    @foreach($ordinances as $ordinance)
                                        <div class="py-4 hover:bg-gray-50 transition rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="text-base font-medium text-gray-900">{{ $ordinance->title }}</h4>
                                                    <div class="mt-1 flex flex-wrap items-center gap-x-4 text-sm text-gray-500">
                                                        <span class="inline-flex items-center">
                                                            <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                            </svg>
                                                            Ordinance #{{ $ordinance->ordinance_number }}
                                                        </span>
                                                        <span class="inline-flex items-center">
                                                            <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $ordinance->date_approved->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ Str::limit($ordinance->content, 150) }}</p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.ordinances.edit', $ordinance) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($ordinances->count() >= 5)
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('admin.ordinances.index', ['search' => $query]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            View all ordinance results
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>