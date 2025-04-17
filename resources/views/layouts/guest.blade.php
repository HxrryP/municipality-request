<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anilao E-Services') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Modern animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Better touch area for mobile */
        @media (max-width: 640px) {
            input[type="checkbox"], 
            input[type="radio"] {
                min-width: 20px;
                min-height: 20px;
            }
            
            button, 
            [type="button"], 
            [type="submit"] {
                min-height: 44px; /* Apple's recommended minimum tap target size */
            }
            
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="date"] {
                min-height: 44px;
                font-size: 16px; /* Prevents iOS zoom on focus */
            }
        }
        
        /* Focus effects */
        input:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            transition: all 0.2s ease;
        }
        
        button {
            transition: all 0.2s ease;
        }
        
        button:active {
            transform: scale(0.98);
        }
        
        /* Better scrolling */
        html {
            height: -webkit-fill-available;
        }
        
        body {
            min-height: 100vh;
            min-height: -webkit-fill-available;
        }
        
        /* Disable auto-zoom on iOS */
        input, select, textarea {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="animate-fade-in">
            {{ $slot }}
        </div>
    </div>
</body>
</html>