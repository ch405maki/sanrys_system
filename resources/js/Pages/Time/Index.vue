<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

// Reactive state to control modal visibility
const isModalOpen = ref(false);

// Function to open the modal
const openModal = () => {
    isModalOpen.value = true;
};

// Function to close the modal
const closeModal = () => {
    isModalOpen.value = false;
};


// Clear interval when component is unmounted
onUnmounted(() => {
    clearInterval(interval);
});

const currentDateTime = ref('');

// Function to update the current date and time
const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleString('en-US', {
        weekday: 'long', // Full weekday name (e.g., "Wednesday")
        year: 'numeric', // Full year (e.g., "2023")
        month: 'long',   // Full month name (e.g., "October")
        day: 'numeric',  // Day of the month (e.g., "25")
        hour: '2-digit', // Hour (e.g., "03")
        minute: '2-digit', // Minute (e.g., "45")
        second: '2-digit', // Second (e.g., "12")
    });
};

// Update date and time every second
let interval;
onMounted(() => {
    interval = setInterval(updateDateTime, 1000); // Update every second
});

// Clear interval when component is unmounted
onUnmounted(() => {
    clearInterval(interval);
});

// Function to handle Time In
const handleTimeIn = () => {
    alert('Time In recorded!'); // Replace with your logic
    closeModal();
};

// Function to handle Time Out
const handleTimeOut = () => {
    alert('Time Out recorded!'); // Replace with your logic
    closeModal();
};
</script>

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
                            <h2 class="font-bold text-gray-800 text-lg">Jane Doe</h2>
                            <p class="text-gray-600">Software Engineer</p>
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
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time In </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Time Out </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-for="index of 4" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> March 5, 2025 </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 8:00 AM </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> 4:00 PM </td>
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
                <button @click="handleTimeIn" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md">
                    Time In
                </button>
                <button @click="handleTimeOut" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md">
                    Time Out
                </button>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>