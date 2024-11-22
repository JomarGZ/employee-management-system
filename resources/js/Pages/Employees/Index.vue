<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout name="Employees">
        <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Employee Management
            </h1>
            <div class="flex space-x-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Add Employee
                </button>
                <button class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v4m0 0l-2-2m2 2l2-2" />
                    </svg>
                    Export CSV
                </button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v4m0 0l-2-2m2 2l2-2" />
                    </svg>
                    Import CSV
                </button>
            </div>
        </header>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6 bg-gray-100">
            <!-- Total Employees Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V3a1 1 0 00-1-1h-4a1 1 0 00-1 1v8M5 13v8a1 1 0 001 1h12a1 1 0 001-1v-8M8 21h8" />
                </svg>
                </div>
                <div>
                <p class="text-lg font-semibold text-gray-700">Total Employees</p>
                <p class="text-2xl font-bold text-gray-900">125</p>
                </div>
            </div>

            <!-- Active Employees Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m-6-6h6M4 16v4m8-6v2m8-6v4m-4-6v6" />
                </svg>
                </div>
                <div>
                <p class="text-lg font-semibold text-gray-700">Active Employees</p>
                <p class="text-2xl font-bold text-gray-900">100</p>
                </div>
            </div>

            <!-- Departments Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m1-6v4M5 5v4m-4 4h16m-4 8v-4" />
                </svg>
                </div>
                <div>
                <p class="text-lg font-semibold text-gray-700">Departments</p>
                <p class="text-2xl font-bold text-gray-900">8</p>
                </div>
            </div>

            <!-- On Leave Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h4m-4 0H8m6-6h4M8 6h4m4 8h4M8 18h4" />
                </svg>
                </div>
                <div>
                <p class="text-lg font-semibold text-gray-700">On Leave</p>
                <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
            </div>
            </div>


        <!-- Search and Filters -->
        <div class="mb-6 flex justify-between items-center">
            <div class="relative w-full max-w-md">
                <input 
                    type="text" 
                    placeholder="Search employees..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-md">
                    <option>Department</option>
                    <option>Engineering</option>
                    <option>HR</option>
                    <option>Sales</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-md">
                    <option>Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>On Leave</option>
                </select>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        JD
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                                    <div class="text-sm text-gray-500">Software Engineer</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">john.doe@company.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Engineering
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            Web Developer
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4.5C7.305 4.5 3.248 7.634 1.5 12c1.748 4.366 5.805 7.5 10.5 7.5s8.752-3.134 10.5-7.5C20.752 7.634 16.695 4.5 12 4.5zm0 12.5c-2.756 0-5-2.239-5-5 0-2.761 2.244-5 5-5 2.756 0 5 2.239 5 5 0 2.761-2.244 5-5 5zm0-8c-1.656 0-3 1.344-3 3s1.344 3 3 3 3-1.344 3-3-1.344-3-3-3z" />
                                    </svg>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 16l4-4v-3H3a1 1 0 00-1 1v7a1 1 0 001 1h12a1 1 0 001-1v-3a1 1 0 00-1-1h-3l4-4v7a3 3 0 01-3 3H5a3 3 0 01-3-3z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Showing 1-10 of 50 employees
            </div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                    Previous
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                    Next
                </button>
            </div>
        </div>
    </div>
    </AppLayout>
</template>