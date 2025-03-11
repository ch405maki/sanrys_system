<template>
    <Head title="Employee Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Profile</h2>
                <a 
                    :href="route('employee.edit', employee.id)" 
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profile
                </a>
            </div>
        </template>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 max-w-4xl mx-auto">
            <div class="grid grid-cols-2 gap-6">
                <div v-if="employee?.profile?.profile_picture" class="col-span-2 flex justify-center items-center">
                    <img 
                        :src="'/storage/' + employee?.profile?.profile_picture" 
                        alt="Profile Picture" 
                        class="w-32 h-32 rounded-full border-4 border-gray-200"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium">Name:</label>
                    <p class="text-gray-900">{{ employee?.name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Email:</label>
                    <p class="text-gray-900">{{ employee?.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Position:</label>
                    <p class="text-gray-900">{{ employee?.profile?.position }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Branch:</label>
                    <p class="text-gray-900">{{ employee?.profile?.branch }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Age:</label>
                    <p class="text-gray-900">{{ employee?.profile?.age }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Contact Number:</label>
                    <p class="text-gray-900">{{ employee?.profile?.contact_number }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Sex:</label>
                    <p class="text-gray-900">{{ employee?.profile?.sex }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Civil Status:</label>
                    <p class="text-gray-900">{{ employee?.profile?.civil_status }}</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium">Present Address:</label>
                    <p class="text-gray-900">{{ employee?.profile?.present_address }}</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium">Permanent Address:</label>
                    <p class="text-gray-900">{{ employee?.profile?.permanent_address }}</p>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    employee: { type: Object, required: true }
});
</script>
