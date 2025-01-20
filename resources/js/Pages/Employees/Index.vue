<script setup>
import AddEmployeeModal from '@/Components/Employees/AddEmployeeModal.vue';
import EmployeeItem from '@/Components/Employees/EmployeeItem.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';
import ImportCsvModal from '@/Components/Employees/ImportCsvModal.vue';
import { useAlert } from '@/Composables/useSweettAlert';
import axios from 'axios';

const {toast, swal} = useAlert();
const props = defineProps({
    employees: Object,
    departments: Object,
    statuses: Array,
    filters: Object,
    employee_counts: Object,
    getCsvExportFileStock: [Object, Array]
});
const exportCsvBtnName = ref('Export CSV');
const isExportProcessing = ref(false);

const CsvExportFileStockLink = ref(props.getCsvExportFileStock.file_path || '');
const CsvExportFileStockStatus = ref(props.getCsvExportFileStock.status || '');
const CsvExportFileStock = ref(props.getCsvExportFileStock || null);

Echo.private(`App.Models.User.${usePage().props.auth.user.id}`)
    .listen('ExportCsvStatusUpdated', function (event) {
        CsvExportFileStockLink.value = event.exportedData?.file_path;
        CsvExportFileStockStatus.value = event.exportedData?.status;
        CsvExportFileStock.value = event.exportedData;
        
        if (CsvExportFileStockStatus.value === 'completed' && typeof CsvExportFileStockLink.value !== 'undefined') {
            window.location.href = CsvExportFileStockLink.value;
            handleExportCleanUp();
        }

    });

const isModalShow = ref(false);
const selectedEmployeeToEdit = ref(null);
const search = ref(props.filters?.search || '');
const status = ref('');
const department_id = ref('');
const returnParams = () => {
    return {
        search: search.value,
        status: status.value ,
        department_id: department_id.value
    }
}
watch(search, debounce(() => {
    if (search) {
        refetchEmployeeData(returnParams())
    }
}, 500))

watch(status, (status) => {
        refetchEmployeeData(returnParams())
});

watch(department_id, (department_id) => {
        refetchEmployeeData(returnParams())
});
const handleEmployeeSubmit = ({form, onSuccess, employee}) => {
    if (selectedEmployeeToEdit.value) {
        updateEmployeeRequest(form, onSuccess, employee);
    } else {
        addEmployeeRequest(form, onSuccess);
    }
}

const handleDelete = (deleteEmployee) => {
    swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('employees.destroy', deleteEmployee), {
                onSuccess: () => {
                    toast.fire({
                        icon: "success",
                        title: "Employee deleted successfully"
                    });
                },
                preserveScroll: true,
            });
        }
    });
  
}

const addEmployeeRequest = (form, onSuccess) => {
    form.post(route('employees.store'), {
        onSuccess: () => {
            toast.fire({
                icon: "success",
                title: "Employee added successfully"
            });
            onSuccess()
        },
    })
}

const updateEmployeeRequest = async (form, onSuccess, employee) => {
    try {
        await form.post(route('employees.update', {employee}), 
            {
                onSuccess: () => {
                    toast.fire({
                        icon: "success",
                        title: "Update employee successfully"
                    });
                    onSuccess()
                },
                onError: (error) => console.log('error', error)
            }
        )
    } catch (error) {
        console.error('Error on updating the employee', error);
    }
  
}



const refetchEmployeeData = async (params) => {
    const {
        search,
        status,
        department_id
    } = params;

    const cleanParams = {
        ...(search !== '' && {search}),
        ...(status !== '' && {status}),
        ...(department_id !== '' && {department_id}),
    };
  
    try {
        await router.get(route('employees.index'),
        cleanParams, 
        {
            preserveScroll: true,
            replace: true,
            preserveState: true
        });
    } catch (error) {
        console.error('Error on refetching the data', error);
    }
}

const handleExport = async () => {
    exportCsvBtnName.value = 'Loading...';
    isExportProcessing.value = true;
    await axios.post(route('export'));
}

const handleExportCleanUp = () => {

   axios.delete(route('employees.export.delete', {export: CsvExportFileStock.value}))
    .then(response => {
        exportCsvBtnName.value = 'Export CSV';
        CsvExportFileStockLink.value = ''
        CsvExportFileStockStatus.value = ''
        isExportProcessing.value = false;
        CsvExportFileStock.value = null;
    })
    .catch(error => {
        console.error('Error on deleting file:', error)
    });
}
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
                    Employees Management
                </h1>
                <div class="flex space-x-4">
                    <AddEmployeeModal
                        :departments="departments"
                        :statuses="statuses"
                        v-model:isModalShow="isModalShow"
                        @emitSubmitEmployeeForm="handleEmployeeSubmit"
                        v-model:selectedEmployeeToEdit="selectedEmployeeToEdit"
                    />
                 
                    <button v-if="CsvExportFileStock && CsvExportFileStockStatus === 'pending'" disabled class="bg-yellow-600 text-white px-4 py-2 rounded-md  flex items-center">
                        <svg aria-hidden="true" class="inline w-5 h-5 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Export is currently processing, Please wait for a moment
                    </button>
                    <button v-else @click="handleExport" :disabled="isExportProcessing" :class="`bg-yellow-600 text-white px-4 py-2 ${!isExportProcessing ? 'hover:bg-yellow-700' : ''} rounded-md hover:bg-yellow-700 flex items-center`">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                            <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v4m0 0l-2-2m2 2l2-2" />
                        </svg>
                       {{ exportCsvBtnName }}
                    </button>
                    <ImportCsvModal />
                </div>
            </header>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 p-6 bg-gray-100">
                <!-- Total Employees Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V3a1 1 0 00-1-1h-4a1 1 0 00-1 1v8M5 13v8a1 1 0 001 1h12a1 1 0 001-1v-8M8 21h8" />
                    </svg>
                    </div>
                    <div>
                    <p class="text-lg font-semibold text-gray-700">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-900">{{ employee_counts?.total_employees || 0 }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ employee_counts?.statuses?.active || 0 }}</p>
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
                    <p class="text-lg font-semibold text-gray-700">Inactive Employees</p>
                    <p class="text-2xl font-bold text-gray-900">{{ employee_counts?.statuses?.inactive || 0 }}</p>
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
                    <p class="text-lg font-semibold text-gray-700">On Leave Employees</p>
                    <p class="text-2xl font-bold text-gray-900">{{ employee_counts?.statuses?.on_leave || 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-gray-700">Onboarding</p>
                        <p class="text-2xl font-bold text-gray-900">{{ employee_counts?.statuses?.onboarding || 0 }}</p>
                    </div>
                </div>
            </div>
            <!-- Search and Filters -->
            <div class="mb-6 flex justify-between items-center">
                <div class="relative w-full max-w-md">
                    <input 
                        type="text"
                        v-model="search" 
                        placeholder="Search employees..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="flex space-x-4">
                    <select v-model="department_id" class="px-4 py-2 border border-gray-300 rounded-md">
                        <option value="">Select All department</option>
                        <option 
                            v-for="dept in departments" 
                            :key="dept.id" 
                            :value="dept.id"
                        >
                            {{ dept.name }}
                    </option>
                    </select>
                    <select v-model="status" class="px-4 py-2 border border-gray-300 rounded-md">
                        <option value="">Select All Status</option>
                        <option 
                            v-for="(status, index) in statuses" 
                            :key="index" 
                            :value="status"
                        >
                            {{ status }}
                    </option>
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
                        <EmployeeItem 
                            v-for="employee in employees?.data" 
                            :key="employee.id"
                            :entity="employee"
                            v-model:selectedEmployeeToEdit="selectedEmployeeToEdit"
                            v-model:isModalShow="isModalShow"
                            @onDelete="handleDelete"
                        />
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="employees?.meta && employees?.links" class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Showing {{employees.meta.from}}-{{ employees.meta.to }} of {{ employees.meta.total }} employees
                </div>
                <div class="flex space-x-2">
                    <Link :href="employees?.links?.prev || ''" :disabled="! employees?.links?.prev || ''" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                        Previous
                    </Link>
                    <Link :href="employees?.links?.next || ''" :disabled="! employees?.links?.next || ''" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>