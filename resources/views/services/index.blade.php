<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Municipal Services') }}
        </h2>
    </x-slot>

    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-r from-blue-700 to-indigo-800 overflow-hidden">
        <div class="absolute inset-0">
            <svg class="h-full w-full text-white/5" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="hero-pattern" width="100" height="100" patternUnits="userSpaceOnUse">
                        <path d="M0 0h100v100H0z" fill="none" />
                        <path d="M100 0v100H0V0h100zM50 30a20 20 0 110 40 20 20 0 010-40z" stroke="currentColor" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-pattern)" />
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="lg:col-span-7">
                    <h1 class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">
                        Anilao E-Services
                    </h1>
                    <p class="mt-3 text-lg text-blue-100 sm:mt-5 sm:text-xl max-w-xl">
                        Access government services online. Apply for permits, request certificates, and make payments from anywhere, anytime.
                    </p>
                    
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="#services-section" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 shadow-md transition duration-150">
                            Browse Services
                        </a>
                        <a href="#how-it-works" class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white/10 transition duration-150">
                            How it Works
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="hidden lg:flex lg:col-span-5 lg:items-center lg:justify-end">
                    <div class="rounded-2xl bg-white/5 backdrop-blur-sm p-8 shadow-lg border border-white/10 transform rotate-2">
                        <div class="space-y-2 mb-4 text-white">
                            <div class="h-2 w-24 bg-white/20 rounded"></div>
                            <div class="h-2 w-32 bg-white/20 rounded"></div>
                            <div class="h-2 w-20 bg-white/20 rounded"></div>
                        </div>
                        <div class="bg-white/10 rounded p-2 flex items-center mb-4">
                            <div class="h-8 w-8 rounded-full bg-white/20 flex-shrink-0"></div>
                            <div class="ml-3">
                                <div class="h-2 w-24 bg-white/20 rounded"></div>
                                <div class="h-2 w-16 bg-white/20 rounded mt-1"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-2 w-full bg-white/20 rounded"></div>
                            <div class="h-2 w-full bg-white/20 rounded"></div>
                            <div class="h-2 w-3/4 bg-white/20 rounded"></div>
                        </div>
                        <div class="mt-4 h-8 w-20 bg-blue-500/30 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-gray-50" id="services-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8 transition-transform hover:shadow-md">
                <form action="{{ route('services.index') }}" method="GET">
                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="flex-grow">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Services</label>
                            <div class="relative rounded-xl">
                                <input type="text" name="search" id="search" class="block w-full rounded-xl border-gray-300 pl-4 pr-12 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="What service are you looking for?" value="{{ request('search') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-56">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="category" name="category" class="block w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="px-5 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition duration-150 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                            
                            @if(request('search') || request('category'))
                                <a href="{{ route('services.index') }}" class="px-5 py-3 border border-gray-300 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Service Categories -->
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Services</h2>

            <!-- Category Pills (Desktop) -->
            <div class="hidden md:flex space-x-4 mb-8 overflow-x-auto py-2 scrollbar-hide">
                <button onclick="showAllCategories()" class="category-filter px-6 py-2 rounded-full text-sm font-medium bg-blue-600 text-white shadow-sm active">
                    All Services
                </button>
                
                @foreach($categories as $category)
                    <button onclick="filterByCategory('{{ $category->slug }}')" class="category-filter px-6 py-2 rounded-full text-sm font-medium bg-white text-gray-600 hover:text-gray-900 border border-gray-200 shadow-sm transition-colors">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            
            <!-- Category Dropdown (Mobile) -->
            <div class="block md:hidden mb-6">
                <select id="mobile-category-filter" class="block w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" onchange="mobileCategoryFilter(this.value)">
                    <option value="all">All Services</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    @foreach($category->services as $service)
                        <div class="service-card category-{{ $category->slug }} bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 transition-all hover:shadow-md hover:-translate-y-1 duration-300">
                            <div class="px-6 py-6">
                                <div class="flex items-start">
                                    @switch($category->slug)
                                        @case('business-permits')
                                            <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                            @break
                                        @case('real-property-tax')
                                            <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-xl bg-green-100 text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                            </span>
                                            @break
                                        @case('local-civil-registry')
                                            <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-xl bg-purple-100 text-purple-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                            @break
                                        @case('occupation-permit-health')
                                            <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-xl bg-red-100 text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </span>
                                            @break
                                        @default
                                            <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-xl bg-gray-100 text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </span>
                                    @endswitch
                                    
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                            {{ $category->name }}
                                        </span>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $service->name }}</h3>
                                    </div>
                                </div>
                                
                                <p class="mt-3 text-sm text-gray-600 line-clamp-3">{{ $service->description }}</p>
                                
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        ₱{{ number_format($service->fee, 2) }}
                                    </div>
                                    
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $service->processing_days }} day(s)
                                    </div>
                                </div>
                                
                                <div class="mt-5 flex justify-between items-center border-t border-gray-100 pt-4">
                                    <div class="text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ count($service->requirements) }} requirements
                                    </div>
                                    
                                    <a href="{{ route('services.show', $service) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            
            <!-- No Services Found Message -->
            <div id="no-services-message" class="hidden text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No services found</h3>
                <p class="mt-2 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
            </div>
        </div>
    </div>
    
    <!-- How It Works Section -->
    <div class="py-16 bg-white" id="how-it-works">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">How It Works</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Complete your service requests in a few simple steps</p>
            </div>
            
            <div class="relative">
                <!-- Steps Timeline (Desktop) -->
                <div class="hidden md:block absolute left-1/2 h-full w-1 bg-gradient-to-b from-blue-400 to-blue-600 transform -translate-x-1/2"></div>
                
                <!-- Steps -->
                <div class="space-y-16 md:space-y-24">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right">
                                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-50 md:mr-4 hover:shadow-lg transition duration-300">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Create an Account</h3>
                                    <p class="text-gray-600">Sign up or log in to access municipal services. Provide basic information to create your personal profile.</p>
                                </div>
                            </div>
                            
                            <div class="hidden md:block md:absolute inset-0 flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full border-4 border-white bg-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold">1</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 md:mt-0 md:w-1/2 md:pl-8">
                                <!-- Empty for desktop layout -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right">
                                <!-- Empty for desktop layout -->
                            </div>
                            
                            <div class="hidden md:block md:absolute inset-0 flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full border-4 border-white bg-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold">2</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 md:mt-0 md:w-1/2 md:pl-8">
                                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-50 md:ml-4 hover:shadow-lg transition duration-300">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Select a Service</h3>
                                    <p class="text-gray-600">Browse available services and select the one you need. Review requirements and fees before proceeding.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right">
                                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-50 md:mr-4 hover:shadow-lg transition duration-300">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                        </svg>
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Submit Required Documents</h3>
                                    <p class="text-gray-600">Complete the application form and upload all required documents. All files are securely stored and processed.</p>
                                </div>
                            </div>
                            
                            <div class="hidden md:block md:absolute inset-0 flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full border-4 border-white bg-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold">3</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 md:mt-0 md:w-1/2 md:pl-8">
                                <!-- Empty for desktop layout -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="relative">
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right">
                                <!-- Empty for desktop layout -->
                            </div>
                            
                            <div class="hidden md:block md:absolute inset-0 flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full border-4 border-white bg-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold">4</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 md:mt-0 md:w-1/2 md:pl-8">
                                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-50 md:ml-4 hover:shadow-lg transition duration-300">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pay Required Fees</h3>
                                    <p class="text-gray-600">Pay securely through GCash or PayMaya. Receive payment confirmation instantly via email and SMS.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="relative">
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/2 md:pr-8 md:text-right">
                                <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-50 md:mr-4 hover:shadow-lg transition duration-300">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Track and Receive</h3>
                                    <p class="text-gray-600">Monitor your request status online. Get notifications when your document is ready for pickup or digital delivery.</p>
                                </div>
                            </div>
                            
                            <div class="hidden md:block md:absolute inset-0 flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full border-4 border-white bg-blue-600 flex items-center justify-center">
                                    <span class="text-white font-bold">5</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 md:mt-0 md:w-1/2 md:pl-8">
                                <!-- Empty for desktop layout -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Frequently Asked Questions</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Find answers to common questions about our e-services</p>
            </div>
            
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ('faq-1')">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">What documents do I need to prepare?</h3>
                                <svg id="faq-1-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 transform rotate-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div id="faq-1-content" class="px-6 pb-4 hidden">
                            <p class="text-gray-600">Document requirements vary depending on the service you're requesting. Each service page lists all required documents. Generally, you'll need a valid ID and service-specific requirements like business registration papers, property documents, or birth/marriage certificates.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ('faq-2')">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">How do I pay for services?</h3>
                                <svg id="faq-2-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 transform rotate-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div id="faq-2-content" class="px-6 pb-4 hidden">
                            <p class="text-gray-600">We offer convenient online payment options through GCash and PayMaya. Once your application is submitted and approved, you'll receive a notification with payment instructions. Simply follow the steps to complete your payment securely.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ('faq-3')">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">How long does processing take?</h3>
                                <svg id="faq-3-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 transform rotate-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div id="faq-3-content" class="px-6 pb-4 hidden">
                            <p class="text-gray-600">Processing times vary by service type. Each service shows its estimated processing time, ranging from same-day completion to several business days. You can track your application status in real-time through your dashboard.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ('faq-4')">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Can I track my request status?</h3>
                                <svg id="faq-4-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 transform rotate-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div id="faq-4-content" class="px-6 pb-4 hidden">
                            <p class="text-gray-600">Yes, you can track your request status anytime through your account dashboard. You'll also receive automatic notifications via email and SMS about important status updates, such as when payment is required or when your document is ready.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-2/3">
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">Need assistance with our services?</h2>
                    <p class="mt-3 text-lg text-blue-100 max-w-3xl">Our support team is ready to help you with any questions about our e-services system.</p>
                </div>
                <div class="mt-8 lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                            Contact Support
                        </a>
                    </div>
                    <div class="ml-3 inline-flex rounded-md shadow">
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 bg-opacity-20 hover:bg-opacity-30">
                            Visit Office
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Category filtering functionality
        function filterByCategory(category) {
            document.querySelectorAll('.service-card').forEach(card => {
                if (!card.classList.contains('category-' + category)) {
                    card.classList.add('hidden');
                } else {
                    card.classList.remove('hidden');
                }
            });
            
            // Update active filter button
            document.querySelectorAll('.category-filter').forEach(button => {
                button.classList.remove('bg-blue-600', 'text-white');
                button.classList.add('bg-white', 'text-gray-600', 'hover:text-gray-900');
            });
            event.currentTarget.classList.remove('bg-white', 'text-gray-600', 'hover:text-gray-900');
            event.currentTarget.classList.add('bg-blue-600', 'text-white');
            
            // Check if any services are shown
            checkForEmptyResults();
        }
        
        function showAllCategories() {
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('hidden');
            });
            
            // Update active filter button
            document.querySelectorAll('.category-filter').forEach(button => {
                button.classList.remove('bg-blue-600', 'text-white');
                button.classList.add('bg-white', 'text-gray-600', 'hover:text-gray-900');
            });
            event.currentTarget.classList.remove('bg-white', 'text-gray-600', 'hover:text-gray-900');
            event.currentTarget.classList.add('bg-blue-600', 'text-white');
            
            // Hide empty results message
            document.getElementById('no-services-message').classList.add('hidden');
        }
        
        function mobileCategoryFilter(category) {
            if (category === 'all') {
                showAllCategories();
            } else {
                document.querySelectorAll('.service-card').forEach(card => {
                    if (!card.classList.contains('category-' + category)) {
                        card.classList.add('hidden');
                    } else {
                        card.classList.remove('hidden');
                    }
                });
                
                // Check if any services are shown
                checkForEmptyResults();
            }
        }
        
        function checkForEmptyResults() {
            // Count visible service cards
            const visibleCards = document.querySelectorAll('.service-card:not(.hidden)').length;
            
            if (visibleCards === 0) {
                document.getElementById('no-services-message').classList.remove('hidden');
            } else {
                document.getElementById('no-services-message').classList.add('hidden');
            }
        }
        
        // FAQ Toggle functionality
        function toggleFAQ(id) {
            const content = document.getElementById(id + '-content');
            const icon = document.getElementById(id + '-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</x-app-layout>