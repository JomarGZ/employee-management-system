<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Modal from '../Modals/Modal.vue';
const props = defineProps({
    isModalShow: {
        type: Boolean,
        default: false
    },
    departments: Object,
    statuses: Array
})
const emit = defineEmits(['update:isModalShow', 'emitSubmitEmployeeForm']);

const form = useForm({
    first_name      : '',
    last_name       : '',
    email           : '',
    phone_number    : '',
    department_id   : '',
    position        : '',
    hire_date       : '',
    salary          : '',
    status          : '',
    image_url       : null,
});

const emitForm = async () => {
    emit('emitSubmitEmployeeForm', {
        form,
        onSuccess: () => {
            onModalClose();
        }
    });
}
const onModalClose = () => {
    emit('update:isModalShow', false)
    emit('update:isModalShow', false);
    form.reset();
}
</script>

<template>
     <button @click="$emit('update:isModalShow', true)" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
        </svg>
        Add Employee
    </button>
    <Teleport to="body">
        <Modal v-if="isModalShow">
            <template #header>
                <div class="flex items-center justify-between text-centers mb-5">
                    <h2 class="text-2xl font-bold text-center text-gray-800">Add New Employee</h2>
                    <button @click="onModalClose" class="hover:bg-gray-100 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
            <template #default>
                <form @submit.prevent="emitForm" class="space-y-4  h-96 overflow-y-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-gray-700 font-semibold mb-2">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                v-model="form.first_name" 
                                id="firstName" 
                                name="firstName" 
                                placeholder="Enter first name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p v-if="form.errors.first_name" class="text-red-500">{{ form.errors.first_name }}</p>
                        </div>
                        <div>
                            <label for="lastName" class="block text-gray-700 font-semibold mb-2">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                v-model="form.last_name" 
                                id="lastName" 
                                name="lastName" 
                                placeholder="Enter last name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p v-if="form.errors.last_name" class="text-red-500">{{ form.errors.last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            v-model="form.email" 
                            name="email" 
                            placeholder="Enter email address"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <p v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="imageUrl" class="block text-gray-700 font-semibold mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="tel"
                            v-model="form.phone_number" 
                            id="imageUrl" 
                            name="imageUrl" 
                            placeholder="Enter phone number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <p v-if="form.errors.phone_number" class="text-red-500">{{ form.errors.phone_number }}</p>
                    </div>

                    <div>
                        <label for="imageUrl" class="block text-gray-700 font-semibold mb-2">
                            Employee Photo
                        </label>
                        <input 
                            type="file"
                            @input="form.image_url = $event.target.files[0]"
                            id="imageUrl" 
                            name="imageUrl" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <p v-if="form.errors.image_url" class="text-red-500">{{ form.errors.image_url }}</p>
                    </div>
                    <div>
                        <label for="department" class="block text-gray-700 font-semibold mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="department"
                            v-model="form.status" 
                            name="department" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Select Status</option>
                            <option 
                                v-for="(status, index) in statuses" 
                                :key="index" 
                                :value="status"
                            >
                                {{ status }}
                            </option>
                        </select>
                        <p v-if="form.errors.department_id" class="text-red-500">{{ form.errors.department_id }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="department" class="block text-gray-700 font-semibold mb-2">
                                Department <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="department"
                                v-model="form.department_id" 
                                name="department" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Select Department</option>
                                <option 
                                    v-for="dept in departments" 
                                    :key="dept.id" 
                                    :value="dept.id"
                                >
                                   {{ dept.name }}
                                </option>
                            </select>
                            <p v-if="form.errors.department_id" class="text-red-500">{{ form.errors.department_id }}</p>
                        </div>
                        <div>
                            <label for="position" class="block text-gray-700 font-semibold mb-2">
                                Position <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                v-model="form.position" 
                                id="position" 
                                name="position" 
                                placeholder="Enter job position"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p v-if="form.errors.position" class="text-red-500">{{ form.errors.position }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="hireDate" class="block text-gray-700 font-semibold mb-2">
                                Hire Date <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                v-model="form.hire_date"
                                id="hireDate" 
                                name="hireDate" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p v-if="form.errors.hire_date" class="text-red-500">{{ form.errors.hire_date }}</p>
                        </div>
                        <div>
                            <label for="salary" class="block text-gray-700 font-semibold mb-2">
                                Salary <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number"
                                v-model="form.salary" 
                                id="salary" 
                                name="salary" 
                                min="0" 
                                step="0.01" 
                                placeholder="Enter salary"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p v-if="form.errors.salary" class="text-red-500">{{ form.errors.salary }}</p>
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
            </template>
        </Modal>
    </Teleport>
</template>