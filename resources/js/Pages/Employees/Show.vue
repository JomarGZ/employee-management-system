<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    employee: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <AppLayout>
        <div class="container mx-auto max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">{{ employee.full_name }}</h1>
                        <p class="text-blue-100">{{ employee.position }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-white text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ employee.status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Personal Information</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">First Name</label>
                                <p class="text-gray-800 font-semibold">{{ employee.first_name }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Last Name</label>
                                <p class="text-gray-800 font-semibold">{{ employee.last_name }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Email</label>
                                <p class="text-gray-800">{{ employee.email }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Phone Number</label>
                                <p class="text-gray-800">{{ employee.phone_number }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Employment Details</h2>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Department</label>
                                <p class="text-gray-800 font-semibold">{{ employee.department?.name }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Position</label>
                                <p class="text-gray-800">{{ employee.position }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Hire Date</label>
                                <p class="text-gray-800">{{ employee.hire_date }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Salary</label>
                                <p class="text-gray-800 font-semibold">$ {{ employee.salary }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Employment History</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">Junior Marketing Coordinator</h3>
                                <span class="text-sm text-gray-600">2020-09-01 - 2022-03-14</span>
                            </div>
                            <p class="text-gray-600">Assisted in developing marketing campaigns and analyzing market trends.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">Marketing Intern</h3>
                                <span class="text-sm text-gray-600">2020-01-15 - 2020-08-31</span>
                            </div>
                            <p class="text-gray-600">Supported marketing team with research and administrative tasks.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Current Projects</h2>
                    <div class="space-y-4">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">Q3 Marketing Campaign</h3>
                                <span class="text-sm text-blue-600 font-medium">In Progress</span>
                            </div>
                            <p class="text-gray-600">Leading the development of integrated marketing strategy for Q3.</p>
                        </div>
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">Social Media Rebranding</h3>
                                <span class="text-sm text-green-600 font-medium">Completed</span>
                            </div>
                            <p class="text-gray-600">Redesigned company's social media presence and content strategy.</p>
                        </div>
                    </div>
                </div> -->

                <div class="mt-8 flex justify-between">
                    <Link :href="route('employees.index')" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                        Back to Employee List
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>