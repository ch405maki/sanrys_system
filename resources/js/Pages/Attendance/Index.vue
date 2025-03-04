<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attendance / <span class="text-xs font-normal text-green-900">Manage Attendance</span></h2>
                </div>
                <div>
                    <a href="" class="bg-green-100 hover:bg-green-200 py-3 px-4 rounded-md border border-green-500 text-gray-700 mr-2"> <i class="fa-solid fa-download mr-2"></i> Download</a>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Attendance management page!</div>
        </main>
    </AuthenticatedLayout>
</template>
