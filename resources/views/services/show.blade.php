<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Details') }}
            </h2>
            <div class="mt-2 md:mt-0">
                <a href="{{ route('services.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Services
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Service Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl overflow-hidden shadow-lg mb-8">
                <div class="relative px-6 py-10 md:px-10 md:py-16 text-white">
                    <div class="absolute inset-0 opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <defs>
                                <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L40 20" fill="none" stroke="#FFF" stroke-width="1" />
                                    <path d="M20 0 L20 40" fill="none" stroke="#FFF" stroke-width="1" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#pattern)" />
                        </svg>
                    </div>
                    
                    <div class="relative md:max-w-2xl">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white mb-4">
                            {{ $service->category->name }}
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $service->name }}</h1>
                        <p class="text-lg text-blue-100">{{ $service->description }}</p>
                        
                        <div class="mt-6 flex flex-wrap gap-4">
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Fee: ₱{{ number_format($service->fee, 2) }}
                            </div>
                            
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Processing Time: {{ $service->processing_days }} day(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Content Column -->
                <div class="md:col-span-2">
                    <!-- Requirements Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Required Documents</h2>
                        </div>
                        
                        <div class="px-6 py-6">
                            <ul class="space-y-3">
                                @foreach($service->requirements as $requirement)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-gray-700">{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Important Note</h3>
                                        <div class="mt-1 text-sm text-blue-700">
                                            <p>Please ensure all documents are clear, complete, and in PDF, JPG, or PNG format. Maximum file size is 2MB per document.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Process Flow Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Application Process</h2>
                        </div>
                        
                        <div class="px-6 py-6">
                            <ol class="relative border-l border-gray-200 ml-3">
                                <li class="mb-8 ml-6">
                                    <span class="flex absolute -left-4 justify-center items-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-bold border-4 border-white">
                                        1
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900">Submit Application</h3>
                                    <p class="text-base text-gray-600 mt-1">Fill out the form completely and upload all required documents.</p>
                                </li>
                                
                                <li class="mb-8 ml-6">
                                    <span class="flex absolute -left-4 justify-center items-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-bold border-4 border-white">
                                        2
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900">Application Review</h3>
                                    <p class="text-base text-gray-600 mt-1">Your application will be reviewed by our staff. You'll be notified if there are any issues.</p>
                                </li>
                                
                                <li class="mb-8 ml-6">
                                    <span class="flex absolute -left-4 justify-center items-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-bold border-4 border-white">
                                        3
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900">Payment</h3>
                                    <p class="text-base text-gray-600 mt-1">Once approved, you'll be notified to pay the required fee through GCash or PayMaya.</p>
                                </li>
                                
                                <li class="ml-6">
                                    <span class="flex absolute -left-4 justify-center items-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-bold border-4 border-white">
                                        4
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900">Completion</h3>
                                    <p class="text-base text-gray-600 mt-1">After payment, your document will be processed and you'll be notified when it's ready for pickup or digital delivery.</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <!-- Right Sidebar -->
                <div class="md:col-span-1">
                    <!-- Action Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 sticky top-8">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                            <h2 class="text-lg font-bold text-gray-900">Request This Service</h2>
                        </div>
                        
                        <div class="px-6 py-6">
                            @auth
                                <a href="{{ route('requests.create', $service) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl text-center shadow-sm transition duration-150 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                    Submit Request
                                </a>
                                
                                <p class="text-xs text-gray-500 mt-3 text-center">By submitting a request, you agree to provide accurate information and comply with municipal regulations.</p>
                            @else
                                <div class="space-y-3">
                                    <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl text-center shadow-sm transition duration-150">
                                        Login to Continue
                                    </a>
                                    
                                    <a href="{{ route('register') }}" class="block w-full bg-white hover:bg-gray-50 text-blue-600 font-medium py-3 px-4 rounded-xl text-center border border-gray-200 transition duration-150">
                                        Create an Account
                                    </a>
                                    
                                    <p class="text-xs text-gray-500 mt-3 text-center">You need an account to request municipal services online.</p>
                                </div>
                            @endauth
                        </div>
                    </div>
                    
                    <!-- Help & Support Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                            <h2 class="text-lg font-bold text-gray-900">Need Help?</h2>
                        </div>
                        
                        <div class="px-6 py-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Contact Support</h3>
                                        <p class="text-sm text-gray-600">Call: (033) 123-4567</p>
                                        <p class="text-sm text-gray-600">Mon-Fri: 8AM - 5PM</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Email Support</h3>
                                        <p class="text-sm text-gray-600">support@anilao.gov.ph</p>
                                        <p class="text-sm text-gray-600">Response within 24 hours</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">Visit Us</h3>
                                        <p class="text-sm text-gray-600">Municipal Hall, Anilao, Iloilo</p>
                                        <p class="text-sm text-gray-600">Open Mon-Fri: 8AM - 5PM</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <a href="#" class="block text-center text-blue-600 hover:text-blue-800 font-medium">
                                    View Service FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Services Section -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Services</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($service->category->services->where('id', '!=', $service->id)->take(3) as $relatedService)
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 transition-all hover:shadow-md hover:-translate-y-1 duration-300">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $relatedService->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $relatedService->description }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        ₱{{ number_format($relatedService->fee, 2) }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $relatedService->processing_days }} day(s)
                                    </span>
                                </div>
                                
                                <a href="{{ route('services.show', $relatedService) }}" class="mt-2 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>