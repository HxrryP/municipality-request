<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Auth::user()->notifications()->count() > 0)
                        <div class="space-y-4">
                            @foreach(Auth::user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
                                <div class="p-4 rounded-md {{ $notification->is_read ? 'bg-white border' : 'bg-blue-50 border border-blue-100' }}">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h4>
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-700">{{ $notification->message }}</p>
                                    
                                    @if($notification->request_id)
                                        <div class="mt-2">
                                            <a href="{{ route('requests.show', $notification->request_id) }}" class="text-xs text-blue-600 hover:text-blue-800">
                                                View Request Details
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">You have no notifications.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mark notifications as read when viewed
        fetch('{{ route("notifications.markAsRead") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    </script>
</x-app-layout>