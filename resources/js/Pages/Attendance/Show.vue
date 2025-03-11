<template>
    <Head title="Time Entries" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full max-w-7xl mx-auto">
                <div>
                    <div class="flex items-center">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full object-cover" :src="'/storage/' + user?.profile?.profile_picture" alt="Profile Picture">
                            <div class="absolute inset-0 rounded-full shadow-inner"></div>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-bold text-gray-800 text-lg">{{user.name}}</h2>
                            <p class="text-gray-600">{{ user.profile.position }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Button to open the modal -->
                    <button @click="openModal" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white">
                        <i class="fa-solid fa-file-arrow-down mr-2"></i> Export
                    </button>
                </div>
            </div>
        </template>

        
        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Time Entries / <span class="text-xs font-normal text-green-900">Manage Time In's Record</span>
                    </h2>
                    <div class="flex items-center">
                        <select class="bg-gray-100 py-2 px-4 rounded-md">
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                        </select>
                    </div>
                </div>
                
                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Date </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Time In </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time Out </th>
                                        <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Action </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-for="attendance in user.attendances" :key="attendance.id" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                            {{ formatDate(attendance.time_in) }}
                                        </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                            {{ formatTime(attendance.time_in) }}
                                        </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                            {{ attendance.time_out ? formatTime(attendance.time_out) : 'N/A' }}
                                        </td>
                                        <td class="flex p-5 items-center justify-center gap-0.5">
                                            <button @click="openUpdateModal(attendance)" class="bg-blue-100 text-sm hover:bg-blue-200 py-2 px-4 rounded-md border border-blue-500 text-blue-700">
                                                <i class="fa-solid fa-pen-to-square"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Update Modal -->
        <div v-if="isUpdateModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg px-6 py-8 w-full max-w-md relative">
                <button @click="closeUpdateModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h3 class="text-lg font-semibold mb-4">Update Attendance</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Time In:</label>
                    <input v-model="updateForm.time_in" type="datetime-local" class="border p-2 rounded-md w-full" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Time Out:</label>
                    <input v-model="updateForm.time_out" type="datetime-local" class="border p-2 rounded-md w-full" />
                </div>
                <button
                    @click="updateAttendance"
                    :disabled="loading"
                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed"
                >
                    <span v-if="!loading">Update</span>
                    <span v-else>
                        <i class="fa-solid fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

// Format date (e.g., "March 5, 2025")
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

// Format time (e.g., "8:00 AM")
const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
    });
};

// Modal state
const isUpdateModalOpen = ref(false);

// Form for updating attendance
const updateForm = ref({
    id: null,
    time_in: '',
    time_out: '',
});

// Loading state
const loading = ref(false);

// Open the update modal
const openUpdateModal = (attendance) => {
    updateForm.value = {
        id: attendance.id,
        time_in: attendance.time_in ? new Date(attendance.time_in).toISOString().slice(0, 16) : '',
        time_out: attendance.time_out ? new Date(attendance.time_out).toISOString().slice(0, 16) : '',
    };
    isUpdateModalOpen.value = true;
};

// Close the update modal
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false;
    updateForm.value = {
        id: null,
        time_in: '',
        time_out: '',
    };
};

// Update attendance
const updateAttendance = async () => {
    loading.value = true;
    try {
        await axios.put(`/api/attendances/${updateForm.value.id}`, {
            time_in: updateForm.value.time_in,
            time_out: updateForm.value.time_out,
        });
        alert('Attendance updated successfully!');
        closeUpdateModal();
        // Refresh the page or update the attendance list
        window.location.reload();
    } catch (error) {
        console.error('Error updating attendance:', error);
        alert('Failed to update attendance. Please try again.');
    } finally {
        loading.value = false;
    }
};
</script>
