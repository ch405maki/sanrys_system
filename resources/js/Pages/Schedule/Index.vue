<template>
    <Head title="Schedule" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full max-w-7xl mx-auto">
                <div>
                    <div class="flex items-center">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schedule / <span class="text-xs font-normal text-green-900">Manage Schedules</span></h2>
                    </div>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- User Table -->
            <div v-if="users && users.length" class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-sm font-medium text-gray-700">Name</th>
                            <th class="px-4 py-4 text-left text-sm font-medium text-gray-700">Email</th>
                            <th class="px-4 py-4 text-left text-sm font-medium text-gray-700">Role</th>
                            <th class="px-4 py-4 text-center text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ user.name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ user.email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ user.role }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 flex justify-center">
                                <button @click="openModal(user)" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mr-2 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Assign Schedule
                                </button>
                                <button @click="openScheduleModal(user)" class="bg-orange-500 text-white px-3 py-2 rounded-md hover:bg-orange-600 flex items-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Schedule
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="text-gray-500">
                No users found.
            </div>

            <!-- Modal for Assigning Schedule -->
            <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg w-full max-w-3xl max-h-[600px] overflow-y-auto">
                    <h3 class="text-lg font-semibold mb-4">Assign Schedule to {{ selectedUser?.name }}</h3>

                    <!-- Form for Assigning Multiple Schedules -->
                    <form @submit.prevent="assignSchedule">
                        <div v-for="(schedule, index) in form.schedules" :key="index" class="mb-4 border-b pb-4">
                            <div class="grid grid-cols-4 gap-4  items-center">
                                <!-- Day of Week -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Day of Week</label>
                                    <select v-model="schedule.day_of_week" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                </div>

                                <!-- Start Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                    <input v-model="schedule.start_time" type="time" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                    <input v-model="schedule.end_time" type="time" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Remove Button -->
                                <div class="flex justify-center items-center col-span-1">
                                    <button type="button" @click="removeSchedule(index)" class="text-red-500 hover:text-red-700 text-lg mt-4">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Another Schedule Button -->
                        <button type="button" @click="addSchedule" class="bg-green-500 hover:bg-green-700 text-white text-sm px-6 py-2 rounded-md shadow-md mb-4 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add
                        </button>

                        <!-- Modal Actions -->
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                                Cancel
                            </button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <!-- Modal Component -->
        <ScheduleModal v-if="showModal" :user="selectedUser" @close="showModal = false" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import ScheduleModal from './ScheduleModal.vue';


const toast = useToast();

// Props
const props = defineProps({
    users: { type: Array },
});

// Log users to verify they are being passed correctly
console.log('Users in Vue:', props.users);

// State for modal and selected user
const isModalOpen = ref(false);
const selectedUser = ref(null);

// State to track which user's schedules are shown
const showSchedules = ref({});

// Form state for multiple schedules
const form = ref({
    user_id: null,
    schedules: [
        {
            day_of_week: 'Monday',
            start_time: '09:00',
            end_time: '17:00',
        },
    ],
});

// Modal state
const showModal = ref(false);

// Open modal with user's schedules
const openScheduleModal = (user) => {
    selectedUser.value = user;
    showModal.value = true;
};

// Open modal and set selected user
const openModal = (user) => {
    selectedUser.value = user;
    form.value.user_id = user.id;
    isModalOpen.value = true;
};

// Close modal
const closeModal = () => {
    isModalOpen.value = false;
    selectedUser.value = null;
    form.value = {
        user_id: null,
        schedules: [
            {
                day_of_week: 'Monday',
                start_time: '09:00',
                end_time: '17:00',
            },
        ],
    };
};

// Add a new schedule to the form
const addSchedule = () => {
    form.value.schedules.push({
        day_of_week: 'Monday',
        start_time: '09:00',
        end_time: '17:00',
    });
};

// Remove a schedule from the form
const removeSchedule = (index) => {
    form.value.schedules.splice(index, 1);
};

const assignSchedule = async () => {
    try {
        const response = await axios.post('/api/schedules', form.value);
        toast.success('Schedules assigned successfully!');
        closeModal();
        setTimeout(() => {
            window.location.reload(); // Refresh the page after a slight delay
        }, 500);
    } catch (error) {
        toast.error('Failed to assign schedules.');
    }
};


// Toggle schedules visibility for a user
const toggleSchedules = (userId) => {
    showSchedules.value[userId] = !showSchedules.value[userId];
};
</script>