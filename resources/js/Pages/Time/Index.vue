<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Time Entries" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Time Entries / <span class="text-xs font-normal text-green-900">Manage Time In's</span></h2>
                </div>
                <div>
                    <a href="" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white"> <i class="fa-solid fa-clock mr-2"></i> Attendance</a>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Time Entries management page!</div>
        </main>
    </AuthenticatedLayout>
</template>
