<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Request Details') }}
            </h2>
            <div class="mt-2 md:mt-0 flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($request->status == 'processing') bg-blue-100 text-blue-800
                    @elseif($request->status == 'payment_required') bg-red-100 text-red-800
                    @elseif($request->status == 'ready_for_pickup') bg-purple-100 text-purple-800
                    @elseif($request->status == 'completed') bg-green-100 text-green-800
                    @elseif($request->status == 'rejected') bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Main Request Information -->
        <div class="md:col-span-3 space-y-6">
            <!-- Basic Request Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Request Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tracking Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->tracking_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->service->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->created_at->format('F d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->updated_at->format('F d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Processing Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->service->processing_days }} day(s)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Service Fee</dt>
                            <dd class="mt-1 text-sm text-gray-900">₱{{ number_format($request->service->fee, 2) }}</dd>
                        </div>
                        @if($request->completed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Completed On</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $request->completed_at->format('F d, Y h:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Processing Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $request->created_at->diffInDays($request->completed_at) }} day(s)</dd>
                            </div>
                        @endif
                        @if($request->remarks)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 bg-yellow-50 p-3 rounded">{{ $request->remarks }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- User Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Mobile Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->mobile_number ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->address ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->created_at->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Requests</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->user->requests()->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Request Form Data -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Form Information</h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 p-4 rounded-md mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Form Data</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                            @foreach($request->form_data as $key => $value)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if(is_array($value))
                                            {{ implode(', ', $value) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                    
                    @if(!empty($request->document_urls))
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Uploaded Documents</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($request->document_urls as $index => $url)
                                    <div class="border border-gray-200 rounded-md p-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-900">
                                                {{ $request->service->requirements[$index] ?? 'Document ' . ($index + 1) }}
                                            </span>
                                        </div>
                                        <a href="{{ Storage::url($url) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                            View
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            @if($request->payment || $request->service->requiresPayment())
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                    </div>
                    <div class="p-6">
                        @if($request->payment)
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reference Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $request->payment->reference_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                    <dd class="mt-1 text-sm text-gray-900">₱{{ number_format($request->payment->amount, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Method</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($request->payment->payment_method) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($request->payment->status == 'paid') bg-green-100 text-green-800
                                            @elseif($request->payment->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->payment->status == 'failed') bg-red-100 text-red-800
                                            @elseif($request->payment->status == 'waived') bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($request->payment->status) }}
                                        </span>
                                    </dd>
                                </div>
                                @if($request->payment->paid_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Paid On</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $request->payment->paid_at->format('F d, Y h:i A') }}</dd>
                                    </div>
                                @endif
                                
                                @if($request->payment->status !== 'paid' && $request->payment->status !== 'waived')
                                    <div class="md:col-span-2 mt-2">
                                        <form action="{{ route('admin.payments.verify', $request->payment) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                                <svg class="mr-2 -ml-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Mark as Paid
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </dl>
                        @elseif($request->service->requiresPayment())
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            No payment has been made for this request. Service fee is ₱{{ number_format($request->service->fee, 2) }}.
                                        </p>
                                        <div class="mt-3 flex space-x-2">
                                            @if($request->status !== 'payment_required')
                                                <form action="{{ route('admin.requests.require-payment', $request) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                                                        Request Payment
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.payments.waive', $request) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                    Waive Payment
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-600">This service doesn't require payment.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Sidebar - Request Actions -->
        <div class="md:col-span-1 space-y-6">
            <!-- Request Actions Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Actions</h3>
                </div>
                <div class="p-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Update Status</h4>
                    
                    <form action="{{ route('admin.requests.update-status', $request) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
                            <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $request->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="payment_required" {{ $request->status == 'payment_required' ? 'selected' : '' }}>Payment Required</option>
                                <option value="ready_for_pickup" {{ $request->status == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                                <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks (Optional)</label>
                            <textarea id="remarks" name="remarks" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Add any notes or remarks here">{{ $request->remarks }}</textarea>
                        </div>
                        
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Status
                        </button>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Quick Actions</h4>
                        
                        <div class="space-y-2">
                            <a href="{{ route('admin.requests.index') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Back to All Requests
                            </a>
                            
                            <a href="mailto:{{ $request->user->email }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Email User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Request Timeline Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Timeline</h3>
                </div>
                <div class="p-6">
                    <ol class="relative border-l border-gray-200">
                        <li class="mb-6 ml-4">
                            <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-1.5 border border-white"></div>
                            <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->created_at->format('M d, Y h:i A') }}</time>
                            <h4 class="text-sm font-medium text-gray-900">Request Submitted</h4>
                            <p class="text-xs text-gray-600">User submitted the request form</p>
                        </li>
                        
                        @if($request->status != 'pending')
                            <li class="mb-6 ml-4">
                                <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->updated_at->format('M d, Y h:i A') }}</time>
                                <h4 class="text-sm font-medium text-gray-900">Status Changed to {{ ucfirst(str_replace('_', ' ', $request->status)) }}</h4>
                                @if($request->remarks)
                                    <p class="text-xs text-gray-600">Remarks: {{ $request->remarks }}</p>
                                @endif
                            </li>
                        @endif
                        
                        @if($request->payment && $request->payment->status === 'paid')
                            <li class="mb-6 ml-4">
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->payment->paid_at->format('M d, Y h:i A') }}</time>
                                <h4 class="text-sm font-medium text-gray-900">Payment Received</h4>
                                <p class="text-xs text-gray-600">₱{{ number_format($request->payment->amount, 2) }} via {{ ucfirst($request->payment->payment_method) }}</p>
                            </li>
                        @endif
                        
                        @if($request->payment && $request->payment->status === 'waived')
                            <li class="mb-6 ml-4">
                                <div class="absolute w-3 h-3 bg-gray-500 rounded-full -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->payment->updated_at->format('M d, Y h:i A') }}</time>
                                <h4 class="text-sm font-medium text-gray-900">Payment Waived</h4>
                                <p class="text-xs text-gray-600">Fee of ₱{{ number_format($request->service->fee, 2) }} was waived</p>
                            </li>
                        @endif
                        
                        @if($request->status === 'completed')
                            <li class="ml-4">
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->completed_at ? $request->completed_at->format('M d, Y h:i A') : $request->updated_at->format('M d, Y h:i A') }}</time>
                                <h4 class="text-sm font-medium text-gray-900">Request Completed</h4>
                                <p class="text-xs text-gray-600">The service request has been fulfilled</p>
                            </li>
                        @endif
                        
                        @if($request->status === 'rejected')
                            <li class="ml-4">
                                <div class="absolute w-3 h-3 bg-red-500 rounded-full -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-500">{{ $request->updated_at->format('M d, Y h:i A') }}</time>
                                <h4 class="text-sm font-medium text-gray-900">Request Rejected</h4>
                                @if($request->remarks)
                                    <p class="text-xs text-gray-600">Reason: {{ $request->remarks }}</p>
                                @endif
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>