
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
    <AppLayout>
        <div class="max-w-lg w- bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Add New Employee</h2>
            <form action="/add-employee" method="post" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-gray-700 font-semibold mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="firstName" 
                            name="firstName" 
                            required 
                            placeholder="Enter first name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    <div>
                        <label for="lastName" class="block text-gray-700 font-semibold mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="lastName" 
                            name="lastName" 
                            required 
                            placeholder="Enter last name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="Enter email address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label for="phoneNumber" class="block text-gray-700 font-semibold mb-2">
                        Phone Number
                    </label>
                    <input 
                        type="tel" 
                        id="phoneNumber" 
                        name="phoneNumber" 
                        placeholder="Enter phone number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="department" class="block text-gray-700 font-semibold mb-2">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="department" 
                            name="department" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Select Department</option>
                            <option value="HR">Human Resources</option>
                            <option value="IT">Information Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                            <option value="Operations">Operations</option>
                        </select>
                    </div>
                    <div>
                        <label for="position" class="block text-gray-700 font-semibold mb-2">
                            Position <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="position" 
                            name="position" 
                            required 
                            placeholder="Enter job position"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="hireDate" class="block text-gray-700 font-semibold mb-2">
                            Hire Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="hireDate" 
                            name="hireDate" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    <div>
                        <label for="salary" class="block text-gray-700 font-semibold mb-2">
                            Salary <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="salary" 
                            name="salary" 
                            required 
                            min="0" 
                            step="0.01" 
                            placeholder="Enter salary"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-300 font-semibold"
                    >
                        Add Employee
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>