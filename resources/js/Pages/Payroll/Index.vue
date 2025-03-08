<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: { type: Array, required: true }
});

</script>

<template>
    <Head title="Payroll" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll / <span class="text-xs font-normal text-green-900">Manage Payroll</span></h2>
                </div>
                <div>
                    <a href="" class="bg-green-100 hover:bg-green-200 py-3 px-4 rounded-md border border-green-500 text-gray-700 mr-2"> <i class="fa-solid fa-download mr-2"></i> Generate</a>
                </div>
            </div>
        </template>
        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" text-gray-900">
                <div class=" overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden rounded-lg">
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Full Name &amp; Email </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Contact Number </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Job Title </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Branch </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize text-center"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-for="user in users" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class=" px-5 py-3">
                                            <div class="w-12 flex items-center gap-3">
                                                <img :src="'/storage/' + user?.profile?.profile_picture" alt="Profile Picture">
                                                <div class="data">
                                                    <p class="font-normal text-sm text-gray-900">{{ user.name }}</p>
                                                    <p class="font-normal text-xs leading-5 text-gray-400"> {{ user.email }} </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ user?.profile?.contact_number }} </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ user?.profile?.position }} </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{ user?.profile?.branch }} </td>
                                        <td class="flex p-5 items-center justify-center gap-0.5">
                                            <a href="" class="bg-green-100 text-sm hover:bg-green-200 py-3 px-4 rounded-md border border-green-500 text-gray-700"> <i class="fa-solid fa-outdent"></i> Generate Payroll</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
