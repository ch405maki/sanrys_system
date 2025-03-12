<template>
    <Head title="Time Entries" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full max-w-7xl mx-auto">
                <div>
                    <div class="flex items-center">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full object-cover" src="/images/profile/profile.png" alt="Avatar">
                            <div class="absolute inset-0 rounded-full shadow-inner"></div>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-bold text-gray-800 text-lg">{{ user.name }}</h2>
                            <p class="text-gray-600">{{ user.profile?.position || 'No position specified' }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Button to open the modal -->
                    <button @click="openModal" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white">
                        <i class="fa-solid fa-clock mr-2"></i> Attendance
                    </button>
                </div>
            </div>
        </template>
        
        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Time Entries / <span class="text-xs font-normal text-green-900">Time In's Record</span>
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
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-2 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 border-r capitalize min-w-[150px]"> Date </th>
                                        <th scope="col" class="p-2 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time In </th>
                                        <th scope="col" class="p-2 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time Out </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-if="filteredAttendances.length === 0">
                                        <td colspan="4" class="text-center p-2 text-gray-500">No Attendance available.</td>
                                    </tr>
                                    <tr v-for="attendance in filteredAttendances" :key="attendance.id" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class="p-2 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 border-r">
                                            {{ formatDate(attendance.time_in) }}
                                        </td>
                                        <td class="p-2 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                            {{ formatTime(attendance.time_in) }}
                                        </td>
                                        <td class="p-2 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                            {{ attendance.time_out ? formatTime(attendance.time_out) : 'No Time In' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal for Time In/Time Out -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg px-6 py-8 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Attendance</h3>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <!-- Display current date and time -->
                <div class="text-center text-gray-600 mb-6">
                    <p>Current Date and Time:</p>
                    <p class="font-semibold">{{ currentDateTime }}</p>
                </div>
                <div class="space-y-4">
                    <button 
                        @click="timeIn"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md"
                        :disabled="hasTimedInToday">
                        {{ hasTimedInToday ? 'Already Timed In' : 'Time In' }}
                    </button>
                    <button @click="timeOut" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md">
                        Time Out
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const { userId, attendances: initialAttendances, user } = defineProps({
    userId: { type: Number, required: true },
    attendances: { type: Array, required: true },
    user: { type: Object, required: true },
});

// Initialize Vue Toastification
const toast = useToast();

// Reactive state
const hasTimedInToday = ref(false);
const isModalOpen = ref(false);
const currentDateTime = ref('');
const monthFilter = ref(new Date().toISOString().slice(0, 7)); // Default to current month (YYYY-MM)

// Filtered attendances based on selected month
const filteredAttendances = computed(() => {
    if (!monthFilter.value) return initialAttendances;

    const [year, month] = monthFilter.value.split('-');
    return initialAttendances.filter(attendance => {
        const date = new Date(attendance.time_in);
        return date.getFullYear() === parseInt(year) && date.getMonth() + 1 === parseInt(month);
    });
});

// Check if the user has already timed in today
const checkIfTimedInToday = async () => {
    try {
        const response = await axios.post('/api/attendances/has-timed-in-today', {
            user_id: userId,
        });
        hasTimedInToday.value = response.data.has_timed_in;
    } catch (error) {
        toast.error('Error checking time-in status.');
        console.error(error);
    }
};

// Time In
const timeIn = async () => {
    try {
        const response = await axios.post('/api/attendances/time-in', { user_id: userId });
        toast.success(response.data.message);
        checkIfTimedInToday();
        setTimeout(() => window.location.reload(), 1000); // Refresh after 1 sec
    } catch (error) {
        toast.error(error.response?.data?.message || 'An error occurred.');
    }
};

// Time Out
const timeOut = async () => {
    try {
        const response = await axios.post('/api/attendances/time-out', { user_id: userId });
        toast.success(response.data.message);
        setTimeout(() => window.location.reload(), 1000); // Refresh after 1 sec
    } catch (error) {
        toast.error(error.response?.data?.message || 'An error occurred.');
    }
};

// Open modal
const openModal = () => {
    isModalOpen.value = true;
};

// Close modal
const closeModal = () => {
    isModalOpen.value = false;
};

// Update current date and time
const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
};

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

// Update date and time every second
let interval;
onMounted(() => {
    interval = setInterval(updateDateTime, 1000);
    checkIfTimedInToday();
});

// Clear interval when component is unmounted
onUnmounted(() => {
    clearInterval(interval);
});
</script>
