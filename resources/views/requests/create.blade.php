<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Request') }} {{ $service->name }}
            </h2>
            <div class="mt-2 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $service->category->name }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base font-medium text-gray-900">Request Progress</h3>
                        <span class="text-sm text-gray-500">Step 1 of 3</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full w-1/3"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-500">
                        <span class="font-medium text-blue-600">Fill Details</span>
                        <span>Upload Documents</span>
                        <span>Payment</span>
                    </div>
                </div>
            </div>

            <!-- Service Info Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-md mb-8 overflow-hidden">
                <div class="md:flex">
                    <div class="p-6 md:p-8 md:w-2/3">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $service->name }}</h3>
                        <p class="text-blue-100 mb-4">{{ $service->description }}</p>
                        
                        <div class="flex flex-wrap gap-3">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900 bg-opacity-50 text-white">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Processing Time: {{ $service->processing_days }} day(s)
                            </div>
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900 bg-opacity-50 text-white">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Fee: ₱{{ number_format($service->fee, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex md:w-1/3 bg-blue-700 justify-center items-center p-6">
                        <svg class="w-32 h-32 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Requirements Accordion -->
            <div x-data="{ open: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <button @click="open = !open" class="w-full px-6 py-4 text-left focus:outline-none flex justify-between items-center bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Requirements</h3>
                    </div>
                    <svg x-show="!open" class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="open" class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Please prepare the following documents before continuing. You'll need to upload them later in the process.
                                </p>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-3">
                        @foreach($service->requirements as $requirement)
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700">{{ $requirement }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Request Form -->
            <form action="{{ route('requests.store', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Personal Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="form_data[name]" id="name" value="{{ Auth::user()->name }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                @error('form_data.name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" name="form_data[email]" id="email" value="{{ Auth::user()->email }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                @error('form_data.email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="form_data[mobile]" id="mobile" value="{{ Auth::user()->mobile_number }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                @error('form_data.mobile')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="form_data[address]" id="address" value="{{ Auth::user()->address }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                @error('form_data.address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Service Specific Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Service Information</h3>
                        </div>
                        
                        <!-- Include the service form component -->
                        <x-service-form :service="$service" />
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Upload All Required Documents</h3>
                        </div>
                        
                        <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Redesigned Upload Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Documents</h3>
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-700">Document Guidelines</h3>
                                <div class="mt-2 text-sm text-gray-600">
                                    <ul class="list-disc space-y-1 pl-5">
                                        <li>Upload clear scanned copies or photos of your documents</li>
                                        <li>Accepted formats: PDF, JPG, PNG (max 2MB each)</li>
                                        <li>Ensure all information is clearly visible</li>
                                        <li>Documents must not be expired</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Redesigned Upload Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Documents</h3>
                    <div id="upload-section" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <!-- Drag-and-Drop Area -->
                        <div class="flex justify-center items-center w-full">
                            <label for="documents" class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <svg class="w-10 h-10 text-gray-400 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18M3 12h18M14 3l3.5 3.5M14 21l3.5-3.5M10 3l3.5 3.5M10 21l3.5-3.5" />
                                </svg>
                                <span class="text-gray-600 text-sm">Drag and drop files here or click to upload</span>
                                <input id="documents" name="documents[]" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Accepted file types: JPEG, PNG, PDF, DOC, DOCX (max size: 50MB)</p>

                        <!-- Error Message -->
                        <div id="error-message" class="mt-2 text-sm text-red-600 hidden"></div>

                        <!-- Progress Section -->
                        <div id="file-upload-progress" class="mt-4 space-y-4">
                            <!-- Progress Items will be dynamically added here -->
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Existing Documents -->
                        @if(isset($request->document_urls) && count($request->document_urls) > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Documents</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($request->document_urls as $index => $url)
                                    <div class="border border-gray-200 rounded-md overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">Document {{ $index + 1 }}</div>
                                        <div class="p-4 flex flex-col space-y-2">
                                            <a href="{{ asset('storage/' . $url) }}" target="_blank" class="text-blue-600 hover:underline">
                                                View Document
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Agreement and Submit -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I agree to the terms and conditions</label>
                                <p class="text-gray-500">I declare that all information provided is true and correct to the best of my knowledge. I understand that providing false information may result in the rejection of my application.</p>
                                @error('terms')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row-reverse sm:justify-between sm:items-center pt-4 border-t border-gray-200">
                            <button type="submit" class="w-full sm:w-auto mb-3 sm:mb-0 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Submit Request
                            </button>
                            
                            <a href="{{ route('services.show', $service) }}" class="w-full sm:w-auto text-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('documents');
            const progressContainer = document.getElementById('file-upload-progress');
            const uploadedFiles = new Set(); // Set to store file hashes (for duplication detection)

            fileInput.addEventListener('change', function (event) {
                const files = event.target.files;

                Array.from(files).forEach((file, index) => {
                    // Generate a unique identifier for the file (hash)
                    const fileId = `${file.name}-${file.size}-${file.lastModified}`;

                    // Check for duplicates
                    if (uploadedFiles.has(fileId)) {
                        alert(`Duplicate file detected: ${file.name}`);
                        return;
                    }

                    // Add the file to the uploadedFiles set
                    uploadedFiles.add(fileId);

                    // Create progress item
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center space-x-4';

                    // File details
                    const fileDetails = document.createElement('div');
                    fileDetails.className = 'flex-1';
                    fileDetails.innerHTML = `
                        <p class="text-sm font-medium text-gray-700">${file.name}</p>
                        <p class="text-xs text-gray-400">${(file.size / (1024 * 1024)).toFixed(2)} MB</p>
                    `;

                    // Progress bar
                    const progressBarContainer = document.createElement('div');
                    progressBarContainer.className = 'flex items-center space-x-2 w-full';

                    const progressBar = document.createElement('div');
                    progressBar.className = 'w-full bg-gray-200 rounded-lg h-2 relative';
                    const progressFill = document.createElement('div');
                    progressFill.className = 'absolute bg-blue-500 h-2 rounded-lg';
                    progressFill.style.width = '0%';

                    progressBar.appendChild(progressFill);
                    progressBarContainer.appendChild(progressBar);

                    // Progress percentage
                    const progressPercentage = document.createElement('span');
                    progressPercentage.className = 'text-xs text-gray-500';
                    progressPercentage.textContent = '0%';

                    progressBarContainer.appendChild(progressPercentage);

                    // Remove button
                    const removeButton = document.createElement('button');
                    removeButton.className = 'text-red-500 hover:text-red-700';
                    removeButton.textContent = '✖';

                    removeButton.addEventListener('click', () => {
                        uploadedFiles.delete(fileId); // Remove file from the set
                        fileItem.remove();
                    });

                    // Assemble progress item
                    fileItem.appendChild(fileDetails);
                    fileItem.appendChild(progressBarContainer);
                    fileItem.appendChild(removeButton);
                    progressContainer.appendChild(fileItem);

                    // Simulate file upload
                    const simulateUpload = setInterval(() => {
                        let currentWidth = parseInt(progressFill.style.width);
                        if (currentWidth < 100) {
                            currentWidth += 10;
                            progressFill.style.width = `${currentWidth}%`;
                            progressPercentage.textContent = `${currentWidth}%`;
                        } else {
                            clearInterval(simulateUpload);
                            progressFill.style.backgroundColor = 'green';
                            progressPercentage.textContent = 'Uploaded';
                        }
                    }, 200);
                });
            });
        });
    </script>
</x-app-layout>