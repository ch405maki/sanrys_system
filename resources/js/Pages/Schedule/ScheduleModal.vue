<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-1/2">
            <div class="p-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Schedules for {{ user.name }}</h3>
                <button @click="emit('close')" class="text-gray-500 hover:text-gray-700">
                    ✖
                </button>
            </div>
            
            <div class="p-4">
                <div v-if="schedules.length > 0">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Day of Week</th>
                                <th class="border border-gray-300 px-4 py-2">Start Time</th>
                                <th class="border border-gray-300 px-4 py-2">End Time</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="schedule in schedules" :key="schedule.id">
                                <td class="border border-gray-300 px-4 py-2">{{ schedule.day_of_week }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ schedule.start_time }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ schedule.end_time }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <button 
                                        @click="removeSchedule(schedule.id)" 
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-500 text-sm text-center mt-2">
                    No schedules assigned.
                </div>
            </div>

            <div class="p-4 flex justify-end">
                <button @click="emit('close')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import { computed } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const props = defineProps({
    user: Object,
});

const emit = defineEmits(['close', 'scheduleRemoved']);
const toast = useToast();

// Local reactive schedules list
const schedules = computed(() => props.user.schedules);

const removeSchedule = async (scheduleId) => {
    try {
        await axios.delete(`/api/schedules/${scheduleId}`);
        schedules.value = schedules.value.filter(schedule => schedule.id !== scheduleId);
        emit('scheduleRemoved', scheduleId);
        
        toast.success('Schedule removed successfully!');
    } catch (error) {
        console.error('Failed to remove schedule:', error);
        toast.error('Error removing schedule. Please try again.');
    }
};
</script>

<style scoped>
/* Ensure FontAwesome icons are properly styled */
i {
    font-size: 1.2rem;
}
</style>
