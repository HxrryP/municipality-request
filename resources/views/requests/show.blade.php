<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Request #{{ $request->tracking_number }}
            </h2>
            <div class="mt-2 md:mt-0 flex items-center">
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($request->status === 'processing') bg-blue-100 text-blue-800
                    @elseif($request->status === 'payment_required') bg-red-100 text-red-800
                    @elseif($request->status === 'completed') bg-green-100 text-green-800
                    @elseif($request->status === 'rejected') bg-red-100 text-red-800
                    @elseif($request->status === 'cancelled') bg-gray-100 text-gray-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Request Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $request->service->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $request->service->description }}</p>
                        </div>

                        <div class="flex flex-col items-end">
                            <p class="text-sm text-gray-600">Submitted on</p>
                            <p class="font-medium text-gray-900">{{ $request->created_at->format('F d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $request->created_at->format('h:i A') }}</p>
                        </div>
                    </div>

                    <!-- Request Status Timeline -->
                    <div class="mt-6">
                        @php
                            $statusOrder = ['pending', 'payment_required', 'processing', 'ready_for_pickup', 'completed'];
                            $currentStatusIndex = array_search($request->status, $statusOrder);
                            if ($currentStatusIndex === false) $currentStatusIndex = 0;
                            $progressPercentage = ($currentStatusIndex / (count($statusOrder) - 1)) * 100;
                            if ($request->status === 'rejected' || $request->status === 'cancelled') $progressPercentage = 0;
                        @endphp

                        <div class="relative">
                            <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                <div style="width: {{ $progressPercentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center
                                    @if($request->status === 'completed') bg-green-500
                                    @elseif($request->status === 'rejected' || $request->status === 'cancelled') bg-red-500
                                    @else bg-blue-500 @endif"></div>
                            </div>

                            <div class="mt-2 grid grid-cols-5 text-xs text-gray-600">
                                <div class="text-left {{ $currentStatusIndex >= 0 ? 'font-medium text-blue-600' : '' }}">Submitted</div>
                                <div class="text-center {{ $currentStatusIndex >= 1 ? 'font-medium text-blue-600' : '' }}">Payment</div>
                                <div class="text-center {{ $currentStatusIndex >= 2 ? 'font-medium text-blue-600' : '' }}">Processing</div>
                                <div class="text-center {{ $currentStatusIndex >= 3 ? 'font-medium text-blue-600' : '' }}">Ready</div>
                                <div class="text-right {{ $currentStatusIndex >= 4 ? 'font-medium text-green-600' : '' }}">Completed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Request Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-500">Tracking Number</div>
                                    <div class="font-medium">{{ $request->tracking_number }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-500">Service Category</div>
                                    <div class="font-medium">{{ $request->service->category->name ?? 'Uncategorized' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-500">Processing Time</div>
                                    <div class="font-medium">{{ $request->service->processing_days }} day(s)</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-500">Service Fee</div>
                                    <div class="font-medium">₱{{ number_format($request->service->fee, 2) }}</div>
                                </div>

                                @if($request->is_renewal)
                                <div class="md:col-span-2">
                                    <div class="text-sm text-gray-500">Renewal of Request</div>
                                    <div class="font-medium">
                                        @if($request->previous_request_id)
                                            <a href="{{ route('requests.show', $request->previous_request_id) }}" class="text-blue-600 hover:text-blue-800">
                                                View Previous Request
                                            </a>
                                        @else
                                            Yes (Previous request not linked)
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form Submission Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Form Information</h3>

                            <!-- Personal Information Section -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-800 mb-3 pb-2 border-b border-gray-200">Personal Information</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if(isset($request->form_data['name']))
                                    <div>
                                        <div class="text-sm text-gray-500">Full Name</div>
                                        <div class="font-medium">{{ $request->form_data['name'] }}</div>
                                    </div>
                                    @endif

                                    @if(isset($request->form_data['email']))
                                    <div>
                                        <div class="text-sm text-gray-500">Email Address</div>
                                        <div class="font-medium">{{ $request->form_data['email'] }}</div>
                                    </div>
                                    @endif

                                    @if(isset($request->form_data['mobile']))
                                    <div>
                                        <div class="text-sm text-gray-500">Mobile Number</div>
                                        <div class="font-medium">{{ $request->form_data['mobile'] }}</div>
                                    </div>
                                    @endif

                                    @if(isset($request->form_data['address']))
                                    <div class="md:col-span-2">
                                        <div class="text-sm text-gray-500">Address</div>
                                        <div class="font-medium">{{ $request->form_data['address'] }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Service Specific Information Section -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-800 mb-3 pb-2 border-b border-gray-200">Service Information</h4>

                                <div class="space-y-4">
                                    @foreach($request->form_data as $key => $value)
                                        @if(!in_array($key, ['name', 'email', 'mobile', 'address']))
                                            <div>
                                                <div class="text-sm text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                                <div class="font-medium">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Submitted Documents -->
                    @if(isset($request->document_urls) && count($request->document_urls) > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Documents</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($request->document_urls as $index => $url)
                                    <div class="border border-gray-200 rounded-md overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">Document {{ $index + 1 }}</div>
                                        <div class="p-4 flex flex-col space-y-2">
                                            <div class="flex items-center justify-center bg-gray-100 rounded-md p-4 h-24">
                                                @php
                                                    $extension = pathinfo($url, PATHINFO_EXTENSION);
                                                @endphp

                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                @elseif(strtolower($extension) === 'pdf')
                                                    <svg class="h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Comments/Remarks (if any) -->
                    @if(isset($request->remarks) && $request->remarks != '')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Remarks</h3>

                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600 mr-3">
                                            <span class="text-sm font-medium">{{ $request->updated_by ? substr($request->updated_by, 0, 1) : 'A' }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center">
                                                <div class="font-medium text-gray-900">{{ $request->updated_by ?? 'Admin' }}</div>
                                                @if(in_array($request->updated_role, ['admin', 'staff']))
                                                    <span class="ml-2 px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ ucfirst($request->updated_role) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}</div>
                                            <div class="mt-2 text-sm text-gray-700">{{ $request->remarks ?? '' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Side Panel -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status Updates</h3>

                            <div class="relative pl-8 space-y-8 before:absolute before:top-0 before:bottom-0 before:left-4 before:border-l-2 before:border-gray-200">
                                <!-- Status Item: Submitted -->
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full
                                        @if($request->status !== 'cancelled' && $request->status !== 'rejected') bg-green-500 @else bg-gray-400 @endif
                                        flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Request Submitted</h4>
                                        <p class="text-xs text-gray-500">{{ $request->created_at->format('M d, Y h:i A') }}</p>
                                        <p class="mt-1 text-sm text-gray-600">Your request has been successfully submitted.</p>
                                    </div>
                                </div>

                                <!-- Status Item: Payment Required (if applicable) -->
                                @if($request->payment)
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full
                                        @if($request->payment->status === 'paid') bg-green-500
                                        @else bg-gray-400 @endif
                                        flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Payment
                                            @if($request->payment->status === 'paid') Completed @else Required @endif
                                        </h4>
                                        @if($request->payment->paid_at)
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($request->payment->paid_at)->format('M d, Y h:i A') }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">{{ now()->format('M d, Y') }}</p>
                                        @endif

                                        <p class="mt-1 text-sm text-gray-600">
                                            @if($request->payment->status === 'paid')
                                                Payment of ₱{{ number_format($request->payment->amount, 2) }} has been received.
                                            @else
                                                Payment of ₱{{ number_format($request->service->fee, 2) }} is required to proceed.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @endif

                                <!-- Status Item: Processing (if applicable) -->
                                @if(in_array($request->status, ['processing', 'ready_for_pickup', 'completed']))
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full
                                        @if(in_array($request->status, ['ready_for_pickup', 'completed'])) bg-green-500
                                        @elseif($request->status === 'processing') bg-blue-500
                                        @else bg-gray-400 @endif
                                        flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Processing</h4>
                                        <p class="text-xs text-gray-500">
                                            @if(isset($request->status_updates['processing_started']))
                                                {{ \Carbon\Carbon::parse($request->status_updates['processing_started'])->format('M d, Y h:i A') }}
                                            @else
                                                In progress
                                            @endif
                                        </p>
                                        <p class="mt-1 text-sm text-gray-600">Your request is being processed by our staff.</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Status Item: Ready for Pickup (if applicable) -->
                                @if(in_array($request->status, ['ready_for_pickup', 'completed']))
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full
                                        @if($request->status === 'completed') bg-green-500
                                        @elseif($request->status === 'ready_for_pickup') bg-green-500
                                        @else bg-gray-400 @endif
                                        flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Ready for Pickup</h4>
                                        <p class="text-xs text-gray-500">
                                            @if(isset($request->status_updates['ready_at']))
                                                {{ \Carbon\Carbon::parse($request->status_updates['ready_at'])->format('M d, Y h:i A') }}
                                            @else
                                                Available now
                                            @endif
                                        </p>
                                        <p class="mt-1 text-sm text-gray-600">Your documents are ready for pickup at the municipal office.</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Status Item: Completed (if applicable) -->
                                @if($request->status === 'completed')
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full bg-green-500 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Completed</h4>
                                        <p class="text-xs text-gray-500">
                                            @if(isset($request->status_updates['completed_at']))
                                                {{ \Carbon\Carbon::parse($request->status_updates['completed_at'])->format('M d, Y h:i A') }}
                                            @else
                                                {{ $request->updated_at->format('M d, Y h:i A') }}
                                            @endif
                                        </p>
                                        <p class="mt-1 text-sm text-gray-600">Your request has been completed successfully.</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Status Item: Cancelled/Rejected (if applicable) -->
                                @if($request->status === 'cancelled' || $request->status === 'rejected')
                                <div class="relative">
                                    <div class="absolute top-1.5 -left-8 h-7 w-7 rounded-full bg-red-500 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ ucfirst($request->status) }}</h4>
                                        <p class="text-xs text-gray-500">{{ $request->updated_at->format('M d, Y h:i A') }}</p>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $request->remarks ??
                                                ($request->status === 'cancelled' ? 'This request has been cancelled.' : 'This request has been rejected.')
                                            }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Timeline Empty State -->
                            @if($request->status === 'pending' && !$request->payment)
                                <div class="mt-4 text-sm text-gray-500 text-center">
                                    <p>Your request is currently being reviewed.</p>
                                    <p>Please check back later for updates.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Section (if applicable) -->
                    @if($request->status === 'payment_required' || $request->payment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>

                            @if($request->payment && ($request->payment->status === 'paid' || $request->payment->status === 'waived'))
                                <!-- Payment completed -->
                                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                @if($request->payment->status === 'paid')
                                                    Payment of ₱{{ number_format($request->payment->amount, 2) }} has been completed on {{ $request->payment->paid_at ? $request->payment->paid_at->format('M d, Y') : 'N/A' }}.
                                                @else
                                                    Payment has been waived by the administrator.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500">Reference Number</div>
                                            <div class="font-medium">{{ $request->payment->reference_number }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Payment Method</div>
                                            <div class="font-medium">{{ ucfirst($request->payment->payment_method) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($request->payment && $request->payment->status === 'pending')
                                <!-- Payment initiated but not completed -->
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Your payment of ₱{{ number_format($request->payment->amount, 2) }} is pending completion.
                                            </p>
                                            @if(isset($request->payment->payment_details['checkout_url']))
                                            <div class="mt-2">
                                                <a href="{{ $request->payment->payment_details['checkout_url'] }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                                                    Complete Payment
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif($request->payment && $request->payment->status === 'failed')
                                <!-- Payment failed -->
                                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">
                                                Your payment attempt has failed. Please try again.
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('payments.show', $request) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                                    Try Again
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                            @if($request->status === 'payment_required')
    @if(session('last_payment_id') && session('last_payment_checkout'))
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Did you already complete your payment but were not redirected properly?
                        <a href="{{ route('payments.recover') }}" class="font-medium underline">Click here</a> to verify your payment status.
                    </p>
                </div>
            </div>
        </div>
    @endif
@endif
                                <!-- No payment initiated yet -->
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                Payment of ₱{{ number_format($request->service->fee, 2) }} is required to proceed with your request.
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('payments.show', $request) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    Pay Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>

                            <div class="space-y-3">
                                <a href="{{ route('requests.track', $request->id) }}" class="block w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                                    Track This Request
                                </a>
                                <a href="{{ route('requests.index') }}" class="block w-full text-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    View All Requests
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Need Help? -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Need Help?</h3>

                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <p class="font-medium text-gray-900">Contact Phone</p>
                                        <p class="text-gray-500">(033) 123-4567</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <p class="font-medium text-gray-900">Email Support</p>
                                        <p class="text-gray-500">support@anilao.gov.ph</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
