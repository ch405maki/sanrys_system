<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
</script>

<template>
    <Head title="Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center p-[5px]">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attendance / <span class="text-xs font-normal text-green-900">Manage Attendance</span></h2>
                </div>
                <div>
                    <!-- Search Section -->
                    <div class="min-w-0 flex-1 col-span-6 ml-[175px] md:block hidden">
                    <div class="flex md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0">
                        <div class="relative text-gray-600">
                            <input class="border border-gray-300 h-10 w-96 pr-16 rounded-lg text-sm placeholder-current focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600"
                                type="search" name="search" placeholder="Search">
                            <button type="submit" class="absolute right-1 top-0 mt-3 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                viewBox="0 0 56.966 56.966" xml:space="preserve" width="512px" height="512px">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23 
                                s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92 
                                c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17 
                                s-17-7.626-17-17S14.61,6,23.984,6z"/>
                            </svg>
                            </button>
                        </div>
                    </div>
                    </div>                
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
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Job Title </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Department </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Branch </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize text-center"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-for="index of 7" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class=" px-5 py-3">
                                            <div class="w-48 flex items-center gap-3">
                                                <img src="https://pagedone.io/asset/uploads/1697536419.png" alt="Floyd image">
                                                <div class="data">
                                                    <p class="font-normal text-sm text-gray-900">Floyd Miles</p>
                                                    <p class="font-normal text-xs leading-5 text-gray-400"> floydmiles@pagedone.io </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> Staff </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> ITC </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> Pasay </td>
                                        <td class="flex p-5 items-center justify-center gap-0.5">
                                            <a :href="route('attendance.show')" class="bg-green-100 text-sm hover:bg-green-200 py-3 px-4 rounded-md border border-green-500 text-gray-700"> <i class="fa-solid fa-calendar-days"></i> Manage Time Entries</a>
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
