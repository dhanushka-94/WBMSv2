<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DN WASSIP - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Water-themed background -->
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 relative overflow-hidden">
            <!-- Decorative water drops -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-10 w-32 h-32 bg-blue-200 rounded-full opacity-20 animate-pulse"></div>
                <div class="absolute top-40 right-20 w-24 h-24 bg-cyan-200 rounded-full opacity-30 animate-pulse delay-1000"></div>
                <div class="absolute bottom-32 left-20 w-40 h-40 bg-blue-100 rounded-full opacity-25 animate-pulse delay-2000"></div>
                <div class="absolute bottom-20 right-32 w-28 h-28 bg-cyan-100 rounded-full opacity-20 animate-pulse delay-3000"></div>
            </div>

            <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                <!-- Logo and Branding -->
                <div class="text-center mb-8">
                    <div class="flex justify-center items-center space-x-4 mb-4">
                        <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-xl">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h1 class="text-3xl font-bold text-gray-800">DN WASSIP</h1>
                            <p class="text-blue-600 font-medium text-lg">Water Supply & Management</p>
                        </div>
                    </div>
                    <div class="max-w-md mx-auto">
                        <h2 class="text-xl font-semibold text-gray-700 mb-2">Dunsinane Estate Water Supply and Management System</h2>
                        <p class="text-gray-600">Customer Relationship Management Portal</p>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="w-full sm:max-w-md px-8 py-8 bg-white/90 backdrop-blur-sm shadow-2xl overflow-hidden rounded-2xl border border-blue-100">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h3>
                        <p class="text-gray-600">Sign in to access your dashboard</p>
                    </div>
                    
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-gray-500 text-sm">
                        © {{ date('Y') }} DN WASSIP. All rights reserved.
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        Dunsinane Estate Water Supply and Management System
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
