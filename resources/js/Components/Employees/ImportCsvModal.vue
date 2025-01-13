<script setup>
import { ref } from 'vue';
import Modal from '../Modals/Modal.vue';
import { useForm } from '@inertiajs/vue3';

const isModalShow = ref(false);
const form = useForm({
    csv_file: null
});
const loading = ref(false);
const fileInput = ref(null);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    form.csv_file = file;
}
const submit = () => {
    if (loading.value === true) return;
    loading.value = true;
    form.post(route('import'), {
        preserveScroll: true,
        onSuccess: (response) => {  
            console.log('success');
        },
        onError: (error) => {
            console.error('Error:', error);
        },
        onFinish: () => {
            loading.value = false;
            isModalShow.value = false;
        }
    })
  
}
</script>

<template>
       <button @click="isModalShow = true"  class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v4m0 0l-2-2m2 2l2-2" />
            </svg>
            Import CSV
        </button>
    <Teleport to="body">
        <Modal v-if="isModalShow">
            <template #default>
                <form @submit.prevent="submit">
                    <input type="file" ref="fileInput" @change="handleFileChange" accept=".csv" class="mb-3">
                    <p v-if="form.errors.csv_file" class="text-red-500">{{ form.errors.csv_file }}</p>
                    <button type="submit" :disabled="loading" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                            <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v4m0 0l-2-2m2 2l2-2" />
                        </svg>
                        Import CSV
                    </button>
                </form>
            </template>
        </Modal>
    </Teleport>
  
</template>