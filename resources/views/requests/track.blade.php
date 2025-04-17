<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Track Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Request Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $request->service->name }}</h3>
                            <div class="mt-1 flex items-center">
                                <span class="text-gray-600 text-sm mr-2">Tracking Number:</span>
                                <span class="font-medium text-sm">{{ $request->tracking_number }}</span>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($request->status == 'pending') bg-yellow-100 text-yellow-800 
                                @elseif($request->status == 'processing') bg-blue-100 text-blue-800 
                                @elseif($request->status == 'payment_required') bg-red-100 text-red-800 
                                @elseif($request->status == 'ready_for_pickup') bg-green-100 text-green-800 
                                @elseif($request->status == 'completed') bg-gray-100 text-gray-800 
                                @elseif($request->status == 'rejected') bg-red-100 text-red-800 
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Request Timeline</h3>
                    
                    <!-- Progress Bar -->
                    <div class="mb-8 px-4">
                        @php
                            $progressPercentage = 0;
                            if ($request->status == 'pending') {
                                $progressPercentage = 20;
                            } elseif ($request->status == 'processing') {
                                $progressPercentage = 40;
                            } elseif ($request->status == 'payment_required') {
                                $progressPercentage = 40;
                            } elseif ($request->status == 'ready_for_pickup') {
                                $progressPercentage = 80;
                            } elseif ($request->status == 'completed') {
                                $progressPercentage = 100;
                            }
                        @endphp
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-xs text-gray-600">
                            <span>Submitted</span>
                            <span>Processing</span>
                            <span>Ready</span>
                            <span>Completed</span>
                        </div>
                    </div>
                    
                    <!-- Detailed Timeline -->
                    <div class="relative border-l-2 border-gray-200 ml-6 pl-8 pb-6">
                        <!-- Submitted -->
                        <div class="mb-10">
                            <div class="absolute -left-2 mt-1.5 w-4 h-4 bg-blue-500 rounded-full"></div>
                            <div>
                                <h4 class="text-base font-medium text-gray-900">Request Submitted</h4>
                                <time class="block text-xs text-gray-500">{{ $request->created_at->format('F d, Y h:i A') }}</time>
                                <p class="mt-1 text-sm text-gray-600">Your request has been submitted successfully and is awaiting review.</p>
                            </div>
                        </div>

                        <!-- Processing -->
                        <div class="mb-10">
                            <div class="absolute -left-2 mt-1.5 w-4 h-4 {{ in_array($request->status, ['processing', 'payment_required', 'ready_for_pickup', 'completed']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full"></div>
                            <div>
                                <h4 class="text-base font-medium {{ in_array($request->status, ['processing', 'payment_required', 'ready_for_pickup', 'completed']) ? 'text-gray-900' : 'text-gray-500' }}">Processing</h4>
                                @if(in_array($request->status, ['processing', 'payment_required', 'ready_for_pickup', 'completed']))
                                    <time class="block text-xs text-gray-500">
                                        @if($request->status == 'payment_required')
                                            {{ $request->updated_at->format('F d, Y h:i A') }}
                                        @else
                                            {{ $request->updated_at->format('F d, Y h:i A') }}
                                        @endif
                                    </time>
                                    <p class="mt-1 text-sm text-gray-600">
                                        @if($request->status == 'payment_required')
                                            Your request has been reviewed and requires payment to proceed.
                                        @else
                                            Your request is being processed by our staff.
                                        @endif
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Waiting for staff review</p>
                                @endif
                            </div>
                        </div>

                        <!-- Payment (if applicable) -->
                        @if($request->payment)
                            <div class="mb-10">
                                <div class="absolute -left-2 mt-1.5 w-4 h-4 {{ $request->payment->status == 'paid' ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full"></div>
                                <div>
                                    <h4 class="text-base font-medium {{ $request->payment->status == 'paid' ? 'text-gray-900' : 'text-gray-500' }}">Payment</h4>
                                    @if($request->payment->status == 'paid')
                                        <time class="block text-xs text-gray-500">{{ $request->payment->paid_at->format('F d, Y h:i A') }}</time>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Payment of ₱{{ number_format($request->payment->amount, 2) }} has been received via {{ ucfirst($request->payment->payment_method) }}.
                                        </p>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">Payment is pending</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Ready for Pickup -->
                        <div class="mb-10">
                            <div class="absolute -left-2 mt-1.5 w-4 h-4 {{ in_array($request->status, ['ready_for_pickup', 'completed']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full"></div>
                            <div>
                                <h4 class="text-base font-medium {{ in_array($request->status, ['ready_for_pickup', 'completed']) ? 'text-gray-900' : 'text-gray-500' }}">Ready for Pickup</h4>
                                @if(in_array($request->status, ['ready_for_pickup', 'completed']))
                                    <time class="block text-xs text-gray-500">{{ $request->updated_at->format('F d, Y h:i A') }}</time>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Your document is ready for pickup at the municipal office. Please bring a valid ID.
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Not yet ready</p>
                                @endif
                            </div>
                        </div>

                        <!-- Completed -->
                        <div>
                            <div class="absolute -left-2 mt-1.5 w-4 h-4 {{ $request->status == 'completed' ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full"></div>
                            <div>
                                <h4 class="text-base font-medium {{ $request->status == 'completed' ? 'text-gray-900' : 'text-gray-500' }}">Completed</h4>
                                @if($request->status == 'completed')
                                    <time class="block text-xs text-gray-500">{{ $request->updated_at->format('F d, Y h:i A') }}</time>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Your request has been completed. Thank you for using our e-services.
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Not yet completed</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estimated Completion -->
                    <div class="mt-8 p-4 bg-blue-50 rounded-md">
                        <h4 class="text-sm font-medium text-blue-800">Estimated Completion</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            @if($request->status == 'completed')
                                This request has been completed.
                            @elseif($request->status == 'rejected')
                                This request has been rejected.
                            @else
                                @php
                                    $processingDays = $request->service->processing_days;
                                    $estimatedDate = $request->created_at->addDays($processingDays);
                                @endphp
                                
                                Expected to be completed by: <strong>{{ $estimatedDate->format('F d, Y') }}</strong>
                                <br>
                                ({{ $processingDays }} business day{{ $processingDays > 1 ? 's' : '' }} from submission)
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('requests.show', $request) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                    Back to Request Details
                </a>
                
                <div>
                    @if($request->status == 'payment_required')
                        <a href="{{ route('payments.show', $request) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Pay Now
                        </a>
                    @endif
                    
                    <a href="{{ route('requests.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        View All Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>