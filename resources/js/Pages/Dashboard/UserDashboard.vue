<template>
    <Head title="User Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Hi, <span class="text-xl font-semibold text-green-800">{{ user.name }}</span>
                </h2>
                <div>
                    <span class="text-xl font-normal text-green-800">/User Dashboard</span>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <!-- Daily Attendance Status -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Daily Attendance Status</h3>
                    <a href="/time" class="bg-green-500 px-4 py-2 rounded-lg text-white hover:bg-green-600">
                        <i class="fa-regular fa-clock w-5 text-center mr-2"></i>
                        Time Entries
                    </a>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-lg font-medium text-center">
                        <span :class="{
                            'text-green-600': dailyAttendanceStatus.status === 'on_time',
                            'text-yellow-600': dailyAttendanceStatus.status === 'late',
                            'text-red-600': dailyAttendanceStatus.status === 'absent',
                        }">
                            {{ dailyAttendanceStatus.message }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- User Schedule Table -->
            <div class="mt-4 bg-white rounded-lg p-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Your Schedule</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 text-left text-sm font-semibold text-gray-900">Day</th>
                                <th class="p-2 text-left text-sm font-semibold text-gray-900">Start Time</th>
                                <th class="p-2 text-left text-sm font-semibold text-gray-900">End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="schedule in user.schedules" :key="schedule.id" class="hover:bg-gray-50 transition-colors">
                                <td class="p-2 text-sm text-gray-900">{{ schedule.day_of_week }}</td>
                                <td class="p-2 text-sm text-gray-900">{{ formatTime(schedule.start_time) }}</td>
                                <td class="p-2 text-sm text-gray-900">{{ formatTime(schedule.end_time) }}</td>
                            </tr>
                            <tr v-if="user.schedules.length === 0">
                                <td colspan="3" class="p-2 text-sm text-gray-500 text-center">No schedule found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    dailyAttendanceStatus: Object,
});

// Format time (e.g., "8:00 AM")
const formatTime = (timeString) => {
    const time = new Date(`1970-01-01T${timeString}`);
    return time.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
    });
};
</script>