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
                            <h2 class="font-bold text-gray-800 text-lg">{{ user.name }}</h2>
                            <p class="text-gray-600">{{ user?.profile?.position }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Button to open the modal -->
                    <button @click="openUploadModal" class="bg-green-600 hover:bg-green-700 py-3 px-4 rounded-md text-white">
                        <i class="fa-solid fa-upload mr-2"></i> Upload Document's
                    </button>
                </div>
            </div>
        </template>
        
        <main class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Uploaded Documents / <span class="text-xs font-normal text-green-900">Manage Documents Record</span>
                    </h2>
                    <!-- Dropdown Filter -->
                    <select v-model="selectedType" class="border border-gray-300 rounded-md p-2 w-56">
                        <option value="">All Types</option>
                        <option v-for="type in uniqueDocumentTypes" :key="type" :value="type">
                            {{ type }}
                        </option>
                    </select>
                </div>

                <div class="overflow-x-auto pb-4">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="table-auto min-w-full rounded-xl">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> File Name </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]"> Type </th>
                                        <th scope="col" class="p-5 text-left whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Description </th>
                                        <th scope="col" class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize"> Action </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <tr v-if="filteredDocuments.length === 0">
                                        <td colspan="4" class="p-5 text-center text-gray-500">No uploaded documents</td>
                                    </tr>
                                    <tr v-for="document in filteredDocuments"  :key="document.id" class="bg-white transition-all duration-500 hover:bg-gray-50">
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{document.document_name}} </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{document.document_type}} </td>
                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{document.description}} </td>
                                        <td class="flex p-5 items-center justify-center gap-2">
                                            <!-- Download Button -->
                                            <a title="Download Document" :href="`/storage/${document.document_path}`" download class="p-2 rounded-full bg-white group transition-all duration-500 hover:bg-indigo-600 flex items-center">
                                                <svg class="w-6 h-6 text-gray-800 hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                                                </svg>
                                            </a>
                                            
                                            <button  @click="deleteDocument(document.id)" class="p-2 rounded-full bg-white group transition-all duration-500 hover:bg-red-600 flex item-center">
                                                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="fill-red-600 group-hover:fill-white" d="M4.00031 5.49999V4.69999H3.20031V5.49999H4.00031ZM16.0003 5.49999H16.8003V4.69999H16.0003V5.49999ZM17.5003 5.49999L17.5003 6.29999C17.9421 6.29999 18.3003 5.94183 18.3003 5.5C18.3003 5.05817 17.9421 4.7 17.5003 4.69999L17.5003 5.49999ZM9.30029 9.24997C9.30029 8.80814 8.94212 8.44997 8.50029 8.44997C8.05847 8.44997 7.70029 8.80814 7.70029 9.24997H9.30029ZM7.70029 13.75C7.70029 14.1918 8.05847 14.55 8.50029 14.55C8.94212 14.55 9.30029 14.1918 9.30029 13.75H7.70029ZM12.3004 9.24997C12.3004 8.80814 11.9422 8.44997 11.5004 8.44997C11.0585 8.44997 10.7004 8.80814 10.7004 9.24997H12.3004ZM10.7004 13.75C10.7004 14.1918 11.0585 14.55 11.5004 14.55C11.9422 14.55 12.3004 14.1918 12.3004 13.75H10.7004ZM4.00031 6.29999H16.0003V4.69999H4.00031V6.29999ZM15.2003 5.49999V12.5H16.8003V5.49999H15.2003ZM11.0003 16.7H9.00031V18.3H11.0003V16.7ZM4.80031 12.5V5.49999H3.20031V12.5H4.80031ZM9.00031 16.7C7.79918 16.7 6.97882 16.6983 6.36373 16.6156C5.77165 16.536 5.49093 16.3948 5.29823 16.2021L4.16686 17.3334C4.70639 17.873 5.38104 18.0979 6.15053 18.2013C6.89702 18.3017 7.84442 18.3 9.00031 18.3V16.7ZM3.20031 12.5C3.20031 13.6559 3.19861 14.6033 3.29897 15.3498C3.40243 16.1193 3.62733 16.7939 4.16686 17.3334L5.29823 16.2021C5.10553 16.0094 4.96431 15.7286 4.88471 15.1366C4.80201 14.5215 4.80031 13.7011 4.80031 12.5H3.20031ZM15.2003 12.5C15.2003 13.7011 15.1986 14.5215 15.1159 15.1366C15.0363 15.7286 14.8951 16.0094 14.7024 16.2021L15.8338 17.3334C16.3733 16.7939 16.5982 16.1193 16.7016 15.3498C16.802 14.6033 16.8003 13.6559 16.8003 12.5H15.2003ZM11.0003 18.3C12.1562 18.3 13.1036 18.3017 13.8501 18.2013C14.6196 18.0979 15.2942 17.873 15.8338 17.3334L14.7024 16.2021C14.5097 16.3948 14.229 16.536 13.6369 16.6156C13.0218 16.6983 12.2014 16.7 11.0003 16.7V18.3ZM2.50031 4.69999C2.22572 4.7 2.04405 4.7 1.94475 4.7C1.89511 4.7 1.86604 4.7 1.85624 4.7C1.85471 4.7 1.85206 4.7 1.851 4.7C1.05253 5.50059 1.85233 6.3 1.85256 6.3C1.85273 6.3 1.85297 6.3 1.85327 6.3C1.85385 6.3 1.85472 6.3 1.85587 6.3C1.86047 6.3 1.86972 6.3 1.88345 6.3C1.99328 6.3 2.39045 6.3 2.9906 6.3C4.19091 6.3 6.2032 6.3 8.35279 6.3C10.5024 6.3 12.7893 6.3 14.5387 6.3C15.4135 6.3 16.1539 6.3 16.6756 6.3C16.9364 6.3 17.1426 6.29999 17.2836 6.29999C17.3541 6.29999 17.4083 6.29999 17.4448 6.29999C17.4631 6.29999 17.477 6.29999 17.4863 6.29999C17.4909 6.29999 17.4944 6.29999 17.4968 6.29999C17.498 6.29999 17.4988 6.29999 17.4994 6.29999C17.4997 6.29999 17.4999 6.29999 17.5001 6.29999C17.5002 6.29999 17.5003 6.29999 17.5003 5.49999C17.5003 4.69999 17.5002 4.69999 17.5001 4.69999C17.4999 4.69999 17.4997 4.69999 17.4994 4.69999C17.4988 4.69999 17.498 4.69999 17.4968 4.69999C17.4944 4.69999 17.4909 4.69999 17.4863 4.69999C17.477 4.69999 17.4631 4.69999 17.4448 4.69999C17.4083 4.69999 17.3541 4.69999 17.2836 4.69999C17.1426 4.7 16.9364 4.7 16.6756 4.7C16.1539 4.7 15.4135 4.7 14.5387 4.7C12.7893 4.7 10.5024 4.7 8.35279 4.7C6.2032 4.7 4.19091 4.7 2.9906 4.7C2.39044 4.7 1.99329 4.7 1.88347 4.7C1.86974 4.7 1.86051 4.7 1.85594 4.7C1.8548 4.7 1.85396 4.7 1.85342 4.7C1.85315 4.7 1.85298 4.7 1.85288 4.7C1.85284 4.7 2.65253 5.49941 1.85408 6.3C1.85314 6.3 1.85296 6.3 1.85632 6.3C1.86608 6.3 1.89511 6.3 1.94477 6.3C2.04406 6.3 2.22573 6.3 2.50031 6.29999L2.50031 4.69999ZM7.05028 5.49994V4.16661H5.45028V5.49994H7.05028ZM7.91695 3.29994H12.0836V1.69994H7.91695V3.29994ZM12.9503 4.16661V5.49994H14.5503V4.16661H12.9503ZM12.0836 3.29994C12.5623 3.29994 12.9503 3.68796 12.9503 4.16661H14.5503C14.5503 2.8043 13.4459 1.69994 12.0836 1.69994V3.29994ZM7.05028 4.16661C7.05028 3.68796 7.4383 3.29994 7.91695 3.29994V1.69994C6.55465 1.69994 5.45028 2.8043 5.45028 4.16661H7.05028ZM2.50031 6.29999C4.70481 6.29998 6.40335 6.29998 8.1253 6.29997C9.84725 6.29996 11.5458 6.29995 13.7503 6.29994L13.7503 4.69994C11.5458 4.69995 9.84724 4.69996 8.12529 4.69997C6.40335 4.69998 4.7048 4.69998 2.50031 4.69999L2.50031 6.29999ZM13.7503 6.29994L17.5003 6.29999L17.5003 4.69999L13.7503 4.69994L13.7503 6.29994ZM7.70029 9.24997V13.75H9.30029V9.24997H7.70029ZM10.7004 9.24997V13.75H12.3004V9.24997H10.7004Z" fill="#F87171"></path>
                                                </svg>
                                            </button>
                                            <button class="p-2 rounded-full bg-white group transition-all duration-500 hover:bg-black flex item-center">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="stroke-black group-hover:stroke-white" d="M10.0161 14.9897V15.0397M10.0161 9.97598V10.026M10.0161 4.96231V5.01231" stroke="black" stroke-width="2.5" stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Upload Modal -->
        <div v-if="isUploadModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg px-6 py-8 w-full max-w-md relative">
                <button @click="closeUploadModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h3 class="text-lg font-semibold mb-4">Upload Document</h3>
                <form @submit.prevent="uploadDocument">
                    <div class="mb-4">
                        <label for="document_name" class="block text-sm font-medium text-gray-700">Document Name</label>
                        <input type="text" id="document_name" v-model="form.document_name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" v-model="form.description" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="document_type" class="block text-sm font-medium text-gray-700">Document Type</label>
                        <select id="document_type" v-model="form.document_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="Compliance">Compliance</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="document" class="block text-sm font-medium text-gray-700">Document</label>
                        <input type="file" id="document" @change="onFileChange" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div v-if="form.document" class="mt-2">
                            <p class="text-sm text-gray-500">Selected file: {{ form.document.name }}</p>
                        </div>
                    </div>

                            <button type="submit" :disabled="isLoading" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-indigo-300">
                        <span v-if="isLoading">Uploading...</span>
                        <span v-else>Upload Document</span>
                    </button>
                </form>

                <!-- Display success/error messages -->
                <div v-if="message" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ message }}
                </div>
                <div v-if="error" class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ error }}
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    user: { type: Array },
});

// Reactive state to control modal visibility
const isUploadModalOpen = ref(false);

// Function to open the modal
const openUploadModal = () => {
    isUploadModalOpen.value = true;
};

// Function to close the modal
const closeUploadModal = () => {
    isUploadModalOpen.value = false;
    resetForm();
};

const selectedType = ref('');

// Extract unique document types
const uniqueDocumentTypes = computed(() => {
    const types = props.user.documents.map(doc => doc.document_type);
    return [...new Set(types)];
});

// Filtered document list based on selected type
const filteredDocuments = computed(() => {
    return selectedType.value
        ? props.user.documents.filter(doc => doc.document_type === selectedType.value)
        : props.user.documents;
});

// Form data
const form = ref({
    user_id: 1,
    document_name: '',
    description: '',
    document_type: '',
    document: null,
});

// Messages and loading state
const message = ref('');
const error = ref('');
const isLoading = ref(false);

// Handle file input change
const onFileChange = (event) => {
    form.value.document = event.target.files[0];
};

// Reset the form
const resetForm = () => {
    form.value = {
        user_id: 1,
        document_name: '',
        description: '',
        document_type: 'ID',
        document: null,
    };
    message.value = '';
    error.value = '';
};

// Upload document
const uploadDocument = async () => {
    isLoading.value = true;
    error.value = '';
    message.value = '';

    const formData = new FormData();
    formData.append('user_id', form.value.user_id);
    formData.append('document_name', form.value.document_name);
    formData.append('description', form.value.description);
    formData.append('document_type', form.value.document_type);
    formData.append('document', form.value.document);

    try {
        const response = await axios.post('/api/documents/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Handle success
        toast.success('Document uploaded successfully!', { timeout: 3000 });

        console.log('Document uploaded successfully:', response.data.document);

        // Wait 3 seconds before closing the modal
        setTimeout(() => {
            resetForm();
            closeUploadModal();
            window.location.reload(); // Refresh the page to reflect changes
        }, 3000);
    } catch (err) {
        // Handle error
        toast.error(err.response?.data?.errors || 'An error occurred while uploading the document.', { timeout: 3000 });
        console.error('Error uploading document:', err);
    } finally {
        isLoading.value = false;
    }
};

const deleteDocument = async (documentId) => {
    if (confirm('Are you sure you want to delete this document?')) {
        try {
            // Call the delete API
            await axios.delete(`/api/documents/${documentId}`);

            // Show success toast
            toast.success('Document deleted successfully!', { timeout: 3000 });

            // Wait 3 seconds before refreshing the page
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } catch (error) {
            console.error('Error deleting document:', error);
            toast.error('Failed to delete document. Please try again.', { timeout: 3000 });
        }
    }
};
</script>
