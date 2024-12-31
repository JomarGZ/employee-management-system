<script setup>
import { useHelper } from '@/Composables/useHelper';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    entity:{
        type: Object,
        required: true
    }
});

const { getInitials } = useHelper();

const emit = defineEmits(['update:selectedEmployeeToEdit', 'update:isModalShow', 'onDelete']);

const onEdit = () => {
    emit('update:selectedEmployeeToEdit', props.entity);
    emit('update:isModalShow', true);
}
</script>
<template>
      <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                    <template v-if="entity.image_url?.thumbnail_60">
                        <img 
                            :src="entity.image_url?.thumbnail_60" 
                            class="h-10 w-10 rounded-full flex items-center justify-center"
                        /> 
                    </template>
                    <template v-else>
                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ getInitials(entity.full_name) }}
                        </div>
                    </template>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ entity.full_name }}</div>
                    <div class="text-sm text-gray-500">Software Engineer</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ entity.email }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                {{ entity.department?.name }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ entity.position }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                {{ entity.status }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
            <div class="flex justify-end space-x-2">
                <Link :href="route('employees.show', {employee: entity})" class="text-blue-600 hover:text-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7.305 4.5 3.248 7.634 1.5 12c1.748 4.366 5.805 7.5 10.5 7.5s8.752-3.134 10.5-7.5C20.752 7.634 16.695 4.5 12 4.5zm0 12.5c-2.756 0-5-2.239-5-5 0-2.761 2.244-5 5-5 2.756 0 5 2.239 5 5 0 2.761-2.244 5-5 5zm0-8c-1.656 0-3 1.344-3 3s1.344 3 3 3 3-1.344 3-3-1.344-3-3-3z" />
                    </svg>
                </Link>
                <button @click="onEdit" class="text-blue-600 hover:text-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 16l4-4v-3H3a1 1 0 00-1 1v7a1 1 0 001 1h12a1 1 0 001-1v-3a1 1 0 00-1-1h-3l4-4v7a3 3 0 01-3 3H5a3 3 0 01-3-3z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button @click="$emit('onDelete', entity)" class="text-red-600 hover:text-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </td>
    </tr>
</template>