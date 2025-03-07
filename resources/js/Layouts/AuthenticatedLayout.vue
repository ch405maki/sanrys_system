    <template>
        <div class=" min-h-screen bg-gray-100">
        <div class="h-full">
            <div class="min-h-full">
            <!-- When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars -->
            <header class="bg-green-600 shadow-sm lg:static py-[5px] lg:overflow-y-visible" :class="{ 'fixed inset-0 z-40 overflow-y-auto': isMenuOpen }">
                <div class="mx-auto max-w-7xl px-4">
                <div class="relative flex justify-between">
                    <!-- Search Section -->
                    <div class="min-w-0 flex-1 lg:py-2 col-span-6 ml-[175px] md:block hidden">
                    <div class="flex md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0">
                        <div class="relative text-gray-600">
                            <input class="border border-gray-300 h-10 w-96 pr-16 rounded-lg text-sm placeholder-current focus:outline-none"
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
    
                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:absolute md:inset-y-0 md:right-0 lg:hidden">
                    <button type="button" class="-mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-100 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500" @click="toggleMenu">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" v-if="!isMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg>
                        <svg class="h-6 w-6" v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    </div>
    
                    <!-- Desktop Actions -->
                    <div class="hidden lg:flex lg:items-center lg:justify-end xl:col-span-4">
                    <svg class="w-6 h-6 text-gray-100 hover:text-gray-300 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                    </svg>

                    <a href="#" class="ml-5 flex-shrink-0 relative rounded-full p-1 text-gray-100 hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-green-200 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                        </svg>
                        
                        <!-- Sidebar Length Notification -->
                        <span class="absolute top-0 mt-[1px] right-0 inline-flex items-center justify-center w-3 h-3 p-3 text-sm font-medium text-green-800 bg-green-100 rounded-full transform translate-x-1/2 -translate-y-1/2">
                        {{ sidebar.length }}
                        </span>
                    </a>
                    <div class="relative ml-5 flex-shrink-0">
                        <button type="button" class="flex rounded-full bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-200 focus:ring-offset-2" @click="toggleProfileMenu">
                            <span class="sr-only">Open user menu</span>
                            <img 
                                class="h-8 w-8 rounded-full" 
                                :src="user.profile_picture ? `/storage/profile_pictures/${$page.props.auth.user.profile_picture}` : '/images/profile/profile.png'" 
                                alt="">
                        </button>
                        <!-- Profile dropdown -->
                        <div v-if="isProfileMenuOpen" @click.away="isProfileMenuOpen = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <a href="#" class="block py-2 px-4 text-sm text-gray-700">Hi, {{ user.name }}</a>
                        <a :href="route('profile.edit')" class="block py-2 px-4 text-sm text-gray-700">Your Profile</a> 
                        <a :href="route('logout')"  as="button" class="block py-2 px-4 text-sm text-gray-700">Sign out</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
    
                <!-- Mobile Menu -->
                <nav v-if="isMenuOpen" class="lg:hidden" aria-label="Global" @click.away="isMenuOpen = false">
                <div class="mx-auto max-w-3xl space-y-1 px-2 pt-2 pb-3 sm:px-4">
                    <!-- admin -->
                    <div class="mt-8 border-t" aria-labelledby="account-headline">
                    <a :href="route('profile.edit')" class="hover:bg-gray-50 text-gray-100 hover:text-gray-600 block rounded-md py-2 px-3 text-base font-medium">Profile</a>
                    <a :href="route('logout')" class="hover:bg-gray-50 block text-gray-100 hover:text-gray-600 rounded-md py-2 px-3 text-base font-medium">Sign out</a>
                    </div>
                </div>
                </nav>
            </header>

            <div class="flex">
                <!-- Sidebar (Sticky & Full Height on Large Screens) -->
                <div class="hidden lg:flex lg:w-64 xl:w-72 h-screen fixed top-0 left-0">
                <Sidebar />
                </div>

                <!-- Main Content Wrapper (Pushes Content to the Right) -->
                <div class="flex-1 lg:ml-64 xl:ml-[250px] py-6 px-4">
                <header v-if="$slots.header" class="mb-6">
                    <div class="max-w-7xl mx-auto py-4 px-6 bg-white rounded-lg">
                    <slot name="header" />
                    </div>
                </header>
                <div>
                    <slot />
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </template>
    
    <script setup>
    import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';
    import { router } from '@inertiajs/vue3';  
    import { Link } from '@inertiajs/vue3';
    import Sidebar from './Partials/Sidebar.vue';
    
    // State management using ref for menu visibility
    const isMenuOpen = ref(false);
    const isProfileMenuOpen = ref(false);
    
    const logout = () => {
        Inertia.post(route('logout'));
    };
    
    // Methods to toggle the menus
    const toggleMenu = () => {
        isMenuOpen.value = !isMenuOpen.value;
    };
    
    const toggleProfileMenu = () => {
        isProfileMenuOpen.value = !isProfileMenuOpen.value;
    };
    
    const sidebar = ref([]); // Store banners as an array
    
        const FetchSidebar = async () => {
        try {
            const response = await fetch('/sidebar');
            sidebar.value = await response.json();
        } catch (error) {
            console.error('Error fetching sidebar:', error);
        }
        };
    
    onMounted(FetchSidebar);
    
    // Ref to manage the visibility of the dropdown
    const showingNavigationDropdown = ref(false);
    
    // Ref to manage the header class
    const headerClass = ref('bg-white shadow pt-16');
    
    // Function to update the header class based on screen size
    const updateHeaderClass = () => {
        if (window.innerWidth >= 640) {
        headerClass.value = 'bg-white shadow';
        } else {
        headerClass.value = 'bg-white shadow pt-16';
        }
    };
    
    // Add event listener on mount
    onMounted(() => {
        updateHeaderClass();
        window.addEventListener('resize', updateHeaderClass);
    });
    
    // Remove event listener before unmount
    onBeforeUnmount(() => {
        window.removeEventListener('resize', updateHeaderClass);
    });
    
    // Use Inertia's usePage hook to access the page props
    const { props } = usePage();
    const user = props.auth.user;
    
    // Computed property to check if the user is a student
    const isStudent = computed(() => {
        return user.role === 'student';
    });
    </script>
    
    <style scoped>

    </style>