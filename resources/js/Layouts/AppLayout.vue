<script setup>
import {provide, ref} from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Sidebar from './sidebar/index.vue';
import TopBar from './topbar/index.vue';
import Toast from 'primevue/toast';


defineProps({
    title: String,
});

const logout = () => {
    router.post(route('logout'));
};

const closed = ref(false)
const toggleSidebar = () => closed.value = !closed.value

provide('closed', closed)

</script>

<template>
    <div>
        <Head :title="title" />
        <Toast />
        <Banner />

        <div class="min-h-screen bg-gray-100">

            <Sidebar :closed="closed"/>

            <TopBar @toggleSidebar="toggleSidebar" :sidebarClosed="closed"/>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main :class="closed ? 'left-[76px]' : 'left-80'"
                  class="transition-all absolute right-0 top-20 bottom-0 overflow-y-auto scrollbar-thumb-gray-300 scrollbar-track-slate-50 scrollbar-thumb-rounded scrollbar-thin">
                <slot/>
            </main>
        </div>
    </div>
</template>
