<script setup>
import {inject} from 'vue';
import {Link} from '@inertiajs/vue3'

defineProps({
    icon: String,
    svg: String,
    label: String,
    active: Boolean,
    href: String,
    child: {
        type: Boolean,
        default: false,
    }
})

const closed = inject('closed', false)
</script>

<template>
    <li class="relative group-aria-expanded:pl-10" :class="{'bg-blue-500 rounded-md': active}">
        <Link :href="href" class="flex items-center space-x-3 p-3 hover:bg-opacity-80 transition-colors text-zinc-100">
            <i v-if="icon && !svg" :class="`pi pi-${icon} ${closed ? 'text-xl' : ''} transition-all`"></i>
            <img v-if="svg" :class="`${closed ? 'text-xl' : ''} transition-all`" :src="svg" alt="">
            <span v-show="!closed" :class="`${active ? '' : 'truncate'} transition-all`">{{ label }}</span>
        </Link>

        <span v-show="false" class="hidden group-hover:block z-20 absolute left-full whitespace-nowrap top-1/2 -translate-y-1/2 bg-black text-white rounded-md p-2">
            {{ label }}
        </span>

        <slot />
    </li>
</template>
