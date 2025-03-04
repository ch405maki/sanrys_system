<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Compliance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compliance / <span class="text-xs font-normal text-green-900">Manage Compliance</span></h2>
                </div>
                <div>
                    <a href="" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white"> <i class="fa-solid fa-file mr-2"></i> Add New</a>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">Compliance management page!</div>
        </main>
    </AuthenticatedLayout>
</template>
