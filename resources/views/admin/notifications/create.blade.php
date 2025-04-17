<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Notification') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Notification title" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="message" rows="4" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Notification message" required></textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="notification_type" class="block text-sm font-medium text-gray-700 mb-1">Notification Type</label>
                        <select name="notification_type" id="notification_type" class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" onchange="toggleUserSelection(this.value)">
                            <option value="admin">Admin Only</option>
                            <option value="system">System-wide</option>
                            <option value="user">Selected Users</option>
                        </select>
                        @error('notification_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div id="users_selection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Users</label>
                        <div class="border border-gray-300 rounded-md p-4 max-h-60 overflow-y-auto">
                            @foreach(\App\Models\User::where('role', 'user')->get() as $user)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" id="user-{{ $user->id }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="user-{{ $user->id }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('users')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('admin.notifications.index') }}" class="mr-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Send Notification
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function toggleUserSelection(type) {
            const userSelectionDiv = document.getElementById('users_selection');
            if (type === 'user') {
                userSelectionDiv.classList.remove('hidden');
            } else {
                userSelectionDiv.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>