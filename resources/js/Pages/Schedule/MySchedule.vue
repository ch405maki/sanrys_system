<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full max-w-7xl mx-auto">
                <div>
                    <div class="flex items-center">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full object-cover" :src="user?.profile?.profile_picture ? '/storage/' + user?.profile?.profile_picture : '/images/profile/profile.png'" alt="Avatar">
                            <div class="absolute inset-0 rounded-full shadow-inner"></div>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-bold text-gray-800 text-lg">{{ user.name }}</h2>
                            <p class="text-gray-600">{{ user.profile?.position || 'No position specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Your Schedule</h2>
            <div v-if="user.schedules.length > 0">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Day of Week</th>
                            <th class="border border-gray-300 px-4 py-2">Start Time</th>
                            <th class="border border-gray-300 px-4 py-2">End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="schedule in user.schedules" :key="schedule.id">
                            <td class="border border-gray-300 px-4 py-2">{{ schedule.day_of_week }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ schedule.start_time }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ schedule.end_time }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-gray-500 text-sm text-center mt-2">
                No schedules assigned.
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    user: {
        type: Object
    }
});
</script>
