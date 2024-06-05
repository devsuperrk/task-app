<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import {computed, inject, onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {Bars3BottomRightIcon} from '@heroicons/vue/24/outline'
defineProps({
    sidebarClosed: Boolean,
})
const page = usePage()
const user = computed(() => page.props.auth?.user);
const showDropdown = ref(false)
onMounted(() => {
    const dropdownContainer = document.getElementById('dropdown-container')
    const dropdownToggler = document.getElementById('dropdown-toggler')
    document.addEventListener('click', (e) => {
        if (dropdownContainer == null) return
        if (dropdownContainer === e.target || dropdownContainer.contains(e.target)
            || dropdownToggler === e.target || dropdownToggler.contains(e.target)) return
        showDropdown.value = false
    })
})

const logout = () => {
    router.post(route('logout'));
};


</script>
<template>

    <div :class="sidebarClosed ? 'left-[76px]' : 'left-80'"
         class="fixed top-0 right-0 bg-white p-5 flex items-center justify-between drop-shadow z-10 h-20 transition-all">
        <div class="flex items-center space-x-3">
            <button @click="$emit('toggleSidebar')">
                <!--                <i class="bi bi-list" style="font-size: 1.5rem"></i>-->
                <Bars3BottomRightIcon class="w-5 h-5"/>
            </button>
            <h3>Dashboard</h3>
        </div>


        <div class="right-header flex items-center">

            <div class="relative" v-if="user">
                <a href="#" @click="showDropdown = !showDropdown" class="flex items-center space-x-3" id="dropdown-toggler">
                    <div class="w-10 h-10 rounded-full border">
                        <img :src="user?.profile_photo_url"
                             class="rounded-full w-full h-full object-cover"/>
                    </div>
                </a>
                <div class="absolute border border-[#D0D5DD] right-0 top-12 bg-white rounded-md shadow-sm pt-2 text-sm text-zinc-700"
                     v-show="showDropdown"
                     id="dropdown-container">
                    <div class="border-[#EAECF0] border-b pb-3">
                        <div class="flex px-3">
                            <div class="shrink-0">
                                <div class="w-10 h-10 rounded-full border">
                                    <img :src="user?.profile_photo_url"
                                         class="rounded-full w-full h-full object-cover"/>
                                </div>
                            </div>
                            <div class="grow ml-3">
                                <p class="font-bold text-gray-700">{{ user?.name }}</p>
                                <p><a class="text-[#475467]" href="mailto:morrison@test.com">{{ user?.email }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-[#EAECF0]">
                        <Link href="/user/profile"
                              class="p-3 text-gray-700 hover:bg-blue-500 w-full text-left hover:text-white transition-colors flex items-center">
                            <svg class="mr-2 " width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.00016 10.0002C9.10473 10.0002 10.0002 9.10473 10.0002 8.00016C10.0002 6.89559 9.10473 6.00016 8.00016 6.00016C6.89559 6.00016 6.00016 6.89559 6.00016 8.00016C6.00016 9.10473 6.89559 10.0002 8.00016 10.0002Z" stroke="#344054" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.485 9.81835C12.4043 10.0011 12.3803 10.2039 12.4159 10.4005C12.4516 10.5971 12.5453 10.7785 12.685 10.9214L12.7214 10.9577C12.8341 11.0703 12.9235 11.204 12.9845 11.3511C13.0455 11.4983 13.0769 11.656 13.0769 11.8153C13.0769 11.9746 13.0455 12.1323 12.9845 12.2795C12.9235 12.4266 12.8341 12.5603 12.7214 12.6729C12.6088 12.7856 12.4751 12.875 12.328 12.936C12.1808 12.997 12.0231 13.0284 11.8638 13.0284C11.7045 13.0284 11.5468 12.997 11.3996 12.936C11.2525 12.875 11.1188 12.7856 11.0062 12.6729L10.9699 12.6365C10.827 12.4968 10.6456 12.4031 10.449 12.3674C10.2524 12.3318 10.0496 12.3559 9.86683 12.4365C9.68758 12.5134 9.5347 12.6409 9.42702 12.8035C9.31933 12.9661 9.26155 13.1567 9.26077 13.3517V13.4547C9.26077 13.7762 9.13306 14.0845 8.90575 14.3118C8.67843 14.5391 8.37012 14.6668 8.04865 14.6668C7.72717 14.6668 7.41887 14.5391 7.19155 14.3118C6.96423 14.0845 6.83653 13.7762 6.83653 13.4547V13.4002C6.83183 13.1996 6.7669 13.005 6.65017 12.8418C6.53344 12.6786 6.37031 12.5543 6.18198 12.485C5.99918 12.4043 5.79641 12.3803 5.59981 12.4159C5.4032 12.4516 5.22179 12.5453 5.07895 12.685L5.04259 12.7214C4.93001 12.8341 4.79633 12.9235 4.64918 12.9845C4.50203 13.0455 4.3443 13.0769 4.18501 13.0769C4.02572 13.0769 3.86799 13.0455 3.72084 12.9845C3.57369 12.9235 3.44001 12.8341 3.32744 12.7214C3.21474 12.6088 3.12533 12.4751 3.06433 12.328C3.00333 12.1808 2.97194 12.0231 2.97194 11.8638C2.97194 11.7045 3.00333 11.5468 3.06433 11.3996C3.12533 11.2525 3.21474 11.1188 3.32744 11.0062L3.3638 10.9699C3.50352 10.827 3.59725 10.6456 3.63289 10.449C3.66854 10.2524 3.64448 10.0496 3.5638 9.86683C3.48697 9.68758 3.35941 9.5347 3.19681 9.42702C3.03421 9.31933 2.84367 9.26155 2.64865 9.26077H2.54562C2.22414 9.26077 1.91584 9.13306 1.68852 8.90575C1.4612 8.67843 1.3335 8.37012 1.3335 8.04865C1.3335 7.72717 1.4612 7.41887 1.68852 7.19155C1.91584 6.96423 2.22414 6.83653 2.54562 6.83653H2.60016C2.80077 6.83183 2.99532 6.7669 3.15853 6.65017C3.32173 6.53344 3.44605 6.37031 3.51531 6.18198C3.59599 5.99918 3.62006 5.79641 3.58441 5.59981C3.54876 5.4032 3.45503 5.22179 3.31531 5.07895L3.27895 5.04259C3.16625 4.93001 3.07685 4.79633 3.01585 4.64918C2.95485 4.50203 2.92345 4.3443 2.92345 4.18501C2.92345 4.02572 2.95485 3.86799 3.01585 3.72084C3.07685 3.57369 3.16625 3.44001 3.27895 3.32744C3.39152 3.21474 3.52521 3.12533 3.67236 3.06433C3.81951 3.00333 3.97723 2.97194 4.13653 2.97194C4.29582 2.97194 4.45355 3.00333 4.6007 3.06433C4.74785 3.12533 4.88153 3.21474 4.9941 3.32744L5.03047 3.3638C5.1733 3.50352 5.35472 3.59725 5.55132 3.63289C5.74792 3.66854 5.9507 3.64448 6.1335 3.5638H6.18198C6.36124 3.48697 6.51411 3.35941 6.6218 3.19681C6.72948 3.03421 6.78726 2.84367 6.78804 2.64865V2.54562C6.78804 2.22414 6.91575 1.91584 7.14306 1.68852C7.37038 1.4612 7.67869 1.3335 8.00016 1.3335C8.32164 1.3335 8.62995 1.4612 8.85726 1.68852C9.08458 1.91584 9.21228 2.22414 9.21228 2.54562V2.60016C9.21306 2.79518 9.27085 2.98572 9.37853 3.14832C9.48621 3.31092 9.63909 3.43849 9.81835 3.51531C10.0011 3.59599 10.2039 3.62006 10.4005 3.58441C10.5971 3.54876 10.7785 3.45503 10.9214 3.31531L10.9577 3.27895C11.0703 3.16625 11.204 3.07685 11.3511 3.01585C11.4983 2.95485 11.656 2.92345 11.8153 2.92345C11.9746 2.92345 12.1323 2.95485 12.2795 3.01585C12.4266 3.07685 12.5603 3.16625 12.6729 3.27895C12.7856 3.39152 12.875 3.52521 12.936 3.67236C12.997 3.81951 13.0284 3.97723 13.0284 4.13653C13.0284 4.29582 12.997 4.45355 12.936 4.6007C12.875 4.74785 12.7856 4.88153 12.6729 4.9941L12.6365 5.03047C12.4968 5.1733 12.4031 5.35472 12.3674 5.55132C12.3318 5.74792 12.3559 5.9507 12.4365 6.1335V6.18198C12.5134 6.36124 12.6409 6.51411 12.8035 6.6218C12.9661 6.72948 13.1567 6.78726 13.3517 6.78804H13.4547C13.7762 6.78804 14.0845 6.91575 14.3118 7.14306C14.5391 7.37038 14.6668 7.67869 14.6668 8.00016C14.6668 8.32164 14.5391 8.62995 14.3118 8.85726C14.0845 9.08458 13.7762 9.21228 13.4547 9.21228H13.4002C13.2051 9.21306 13.0146 9.27085 12.852 9.37853C12.6894 9.48621 12.5618 9.63909 12.485 9.81835Z" stroke="#344054" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Profile Settings
                        </Link>
                    </div>
                    <button class="p-3 text-gray-700 hover:bg-blue-500 w-full text-left hover:text-white transition-colors flex items-center"
                            @click.prevent="logout"><svg class="mr-2 " xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path class="fill-gray-700" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"/></svg> Log out
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
