<script setup>
import {inject, ref} from 'vue';

defineProps({
    icon: String,
    svg: String,
    label: String,
    active: Boolean,
    href: String,
});

const closed = inject('closed', false);
</script>

<template>
    <li class="relative group">
        <a href="#"
           @click="active = !active"
           :class="`flex items-center space-x-3 p-3 rounded-md hover:bg-opacity-80 transition-colors ${active ? 'text-white bg-blue-500' : 'text-zinc-100'} ${closed ? 'justify-center' : '' }`">
            <i v-if="icon && !svg" :class="`bi bi-${icon} ${closed ? 'text-xl' : ''} transition-all`"></i>
            <img v-if="svg" :class="`${closed ? 'text-xl' : ''} transition-all`" :src="svg" alt="">
            <span v-show="!closed" :class="`${active ? '' : 'truncate'} transition-all`" style="margin-right: 1.75rem;">{{ label }}</span>
            <i v-show="!closed" :class="`bi bi-chevron-${active ? 'up' : 'down'} ${closed ? 'text-xl' : ''} transition-all absolute right-3`"></i>
        </a>

        <span v-show="closed"
              class="hidden group-hover:block z-20 absolute left-full whitespace-nowrap top-1/2 -translate-y-1/2 bg-black text-white rounded-md p-2 ml-3">{{
                label
            }}</span>

        <ul v-show="!closed" class="group pt-1" :class="{'hidden': !active}" :aria-expanded="active">
            <slot />
        </ul>
    </li>
</template>
