<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hi, <span class="text-xl font-semibold text-green-800">Administrator</span></h2>
                <div>
                    <span class="text-xl font-normal text-green-800">/Dashboard</span>
                </div>
            </div>
        </template>

        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're logged in!</div>
        </main>
    </AuthenticatedLayout>
</template>
