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
                    <button @click="exportToExcel" class="bg-green-100 hover:bg-green-200 py-2 px-4 rounded-md border border-green-500 text-gray-700"> 
                            <i class="fa-solid fa-download mr-2"></i>
                            Download
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
                        <input 
                            type="month" 
                            v-model="monthFilter" 
                            class="bg-gray-100 py-2 px-4 rounded-md"
                            @change="filterByMonth"
                        />
                    </div>
                </div>
                
                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table id="Attendance" class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Date </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Time In </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time Out </th>
                                        <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Action </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-if="filteredAttendances.length === 0">
                                        <td colspan="4" class="text-center p-5 text-gray-500">No Attendance available.</td>
                                    </tr>
                                    <tr v-for="attendance in filteredAttendances" :key="attendance.id" class="bg-white transition-all duration-500 hover:bg-gray-50">
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
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import * as XLSX from 'xlsx';

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

const monthFilter = ref(new Date().toISOString().slice(0, 7)); // Default to current month (e.g., "2025-03")

const filteredAttendances = computed(() => {
    if (!props.user.attendances) return [];
    
    return props.user.attendances.filter(attendance => {
        const entryMonth = new Date(attendance.time_in).toISOString().slice(0, 7); // Format as "YYYY-MM"
        return entryMonth === monthFilter.value;
    });
});

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

const exportToExcel = () => {
    const table = document.getElementById('Attendance');
    
    // Clone the table to manipulate it without affecting the original
    const clonedTable = table.cloneNode(true);

    // Remove the 'Action' column from the cloned table
    const headers = clonedTable.querySelectorAll('thead th');
    const bodyRows = clonedTable.querySelectorAll('tbody tr');

    // Identify the 'Action' column index
    let actionColumnIndex = -1;
    headers.forEach((th, index) => {
        if (th.textContent.trim() === 'Action') {
            actionColumnIndex = index;
            th.remove(); // Remove the header
        }
    });

    // Remove the corresponding cells in each row
    bodyRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells[actionColumnIndex]) {
            cells[actionColumnIndex].remove();
        }
    });

    // Export the modified table
    const workbook = XLSX.utils.table_to_book(clonedTable);
    XLSX.writeFile(workbook, 'Attendance_Report.xlsx');
};

</script>
