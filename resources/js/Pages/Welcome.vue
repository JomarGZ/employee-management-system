<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
     <!-- Decorative circles -->
     <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 rounded-full bg-blue-200 opacity-20 blur-xl"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 rounded-full bg-indigo-200 opacity-20 blur-xl"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
            <!-- Left Side Content -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                    <span class="block">Welcome to</span>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                        EMS Portal
                    </span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 max-w-2xl">
                    Manage your workforce efficiently with our comprehensive employee management solution. Streamline HR processes and boost productivity.
                </p>
                
                <!-- Features Grid -->
                <div class="mt-8 grid grid-cols-2 gap-4 max-w-lg mx-auto md:mx-0">
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-sm">
                        <div class="w-8 h-8 mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Employee Data</h3>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-sm">
                        <div class="w-8 h-8 mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Task Management</h3>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-sm">
                        <div class="w-8 h-8 mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Analytics</h3>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-sm">
                        <div class="w-8 h-8 mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Attendance</h3>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <Link :href="route('login')" class="px-8 py-3 text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Login
                    </Link>
                    <!-- <Link :href="route('register')" class="px-8 py-3 text-base font-medium rounded-xl text-blue-600 bg-white hover:bg-blue-50 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl border border-blue-100">
                        Register
                    </Link> -->
                </div>
            </div>

            <!-- Right Side Illustration -->
            <div class="flex-1 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-3xl transform rotate-3"></div>
                <div class="relative bg-white p-6 rounded-3xl shadow-xl">
                    <div class="aspect-w-4 aspect-h-3">
                        <img src="/api/placeholder/600/450" alt="Dashboard Preview" class="rounded-lg object-cover">
                    </div>
                    <!-- Floating Cards -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-lg shadow-lg transform -rotate-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100"></div>
                            <div class="space-y-1">
                                <div class="h-2 w-20 bg-gray-200 rounded"></div>
                                <div class="h-2 w-16 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-6 -right-6 bg-white p-4 rounded-lg shadow-lg transform rotate-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100"></div>
                            <div class="space-y-1">
                                <div class="h-2 w-20 bg-gray-200 rounded"></div>
                                <div class="h-2 w-16 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
