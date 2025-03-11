<template>
    <Head title="Upload Document's" />

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
            </div>
        </template>
        
        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900">
                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle p-4">
                        <div class="overflow-hidden">
                            <div class="grid grid-cols-1 border">
                                <div class="bg-green-100 p-4 font-semibold">Salary Brakedown</div>
                            </div>
                            <div class="grid grid-cols-1 border sm:grid-cols-2 md:grid-cols-3">
                                <div class="border-r p-3">Monthly Rate <br>₱ {{ user.salary.monthly_rate }}</div>
                                <div class="border-r p-3">Rate Per Day <br>₱ {{ user.salary.rate_per_day }}</div>
                                <div class="p-3">Allowance <br>₱ {{ user.salary.allowance }}</div>
                            </div>
                            <div class="mt-8 grid grid-cols-1 border">
                                <div class="bg-red-100 p-4 font-semibold">Contributions</div>
                            </div>
                            <div class="grid grid-cols-1 border sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                <div class="border-r p-3">SSS <br>₱ {{user.deductions.sss}} </div>
                                <div class="border-r p-3">Pag-Ibig <br>₱ {{user.deductions.pag_ibig}} </div>
                                <div class="border-r p-3">Philhealth <br>₱ {{user.deductions.philhealth}}</div>
                                <div class="p-3">Maxicare <br>₱ {{user.deductions.maxicare}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps ({
    user: {type: Array},
})

</script>
