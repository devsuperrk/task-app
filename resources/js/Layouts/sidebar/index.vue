<script setup>
import {computed, inject, onMounted, onUnmounted, ref} from "vue";
import NavItem from "@/Layouts/sidebar/nav-item.vue";
import {Link, useForm, router, usePage} from "@inertiajs/vue3";

const closed = inject("closed", false);
const expandAccount = ref(false);

const page = usePage();
const user = computed(() => page.props?.auth?.user);

const dropdownOpen = ref(false);
const dropdownRef = ref(null);
const onClick = (e) => {
    /*console.log(
        dropdownRef.value.contains(e.target) || dropdownRef.value === e.target
    );*/
    if (e.target && dropdownRef.value) {
        dropdownOpen.value = dropdownRef.value.contains(e.target) || dropdownRef.value === e.target;
    }
};
onMounted(() => document.addEventListener("click", onClick));
onUnmounted(() => document.removeEventListener("click", onClick));
</script>

<template>
    <nav
        :class="closed ? 'w-[76px]' : 'w-80'"
        class="relative overflow-x-hidden transition-width h-screen bg-blue-600 text-white space-y-2 pt-5 max-h-screen overflow-y-auto scrollbar-thumb-slate-200 scrollbar-track-slate-50 scrollbar-thumb-rounded scrollbar-thin"
    >
        <div :class="{ 'px-5': !closed }">
            <Link :href="route('dashboard')" class="flex items-center">
                <img class="h-8 w-auto mr-2" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="Your Company" />
                Task App
<!--                <img
                    :src="!closed ? 'https://tailwindui.com/img/logos/mark.svg?color=white' : '/logo-circle.png'"
                    :width="closed ? 32 : 150"
                    class="rounded-md mb-5"
                    :class="!closed ? '' : 'mx-5'"
                    alt="Task Logo"
                />-->
            </Link>
        </div>

        <div class="w-full">
            <ul
                class="p-5 border-t border-white border-opacity-30 space-y-2"
                :class="{ 'px-3': closed }"
            >
                <NavItem
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    icon="home"
                    label="Dashboard"
                />
                <NavItem
                    :href="route('tasks.index')"
                    :active="route().current('tasks.*')"
                    icon="list"
                    label="Tasks"
                />
            </ul>
        </div>
    </nav>
</template>
