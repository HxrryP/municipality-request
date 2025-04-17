<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('admin.requests.index', ['status' => 'pending']) }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:bg-gray-50 transition duration-150 group">
                <div class="h-10 w-10 flex-shrink-0 bg-yellow-100 rounded-md flex items-center justify-center">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-base font-medium text-gray-900 group-hover:text-gray-900">Review Pending Requests</p>
                    <p class="text-sm text-gray-500 group-hover:text-gray-700">Process new service requests from citizens</p>
                </div>
                <div>
                    <svg class="h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('admin.requests.index', ['status' => 'payment_required']) }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:bg-gray-50 transition duration-150 group">
                <div class="h-10 w-10 flex-shrink-0 bg-red-100 rounded-md flex items-center justify-center">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-base font-medium text-gray-900 group-hover:text-gray-900">Verify Payments</p>
                    <p class="text-sm text-gray-500 group-hover:text-gray-700">Process and verify pending payments</p>
                </div>
                <div>
                    <svg class="h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('admin.services.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:bg-gray-50 transition duration-150 group">
                <div class="h-10 w-10 flex-shrink-0 bg-green-100 rounded-md flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-base font-medium text-gray-900 group-hover:text-gray-900">Add New Service</p>
                    <p class="text-sm text-gray-500 group-hover:text-gray-700">Create a new service offering for citizens</p>
                </div>
                <div>
                    <svg class="h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('admin.ordinances.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center hover:bg-gray-50 transition duration-150 group">
                <div class="h-10 w-10 flex-shrink-0 bg-purple-100 rounded-md flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-base font-medium text-gray-900 group-hover:text-gray-900">Publish Ordinance</p>
                    <p class="text-sm text-gray-500 group-hover:text-gray-700">Add a new municipal ordinance to the system</p>
                </div>
                <div>
                    <svg class="h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</div>