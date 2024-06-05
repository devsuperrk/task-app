<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/vue/20/solid'
import { CursorArrowRaysIcon, EnvelopeOpenIcon, UsersIcon } from '@heroicons/vue/24/outline'
import {usePage} from "@inertiajs/vue3";
import {computed, ref, watch} from "vue";

const page = usePage();
const user = computed(() => page.props?.auth?.user);

const props = defineProps({
    stats: {
        type: Object,
        required: true
    }
});

const stats = ref([
    { id: 2, name: 'Total Todo', stat: '', code: 'totalTodoTask', icon: UsersIcon },
    { id: 3, name: 'Total Progressing', stat: '', code: 'totalProcessingTask', icon: EnvelopeOpenIcon},
    { id: 1, name: 'Total Done', code: 'totalDoneTask', stat: '', icon: CursorArrowRaysIcon},
]);

watch(() => props.stats, (newStats) => {
    stats.value.forEach((item) => {
        item.stat = newStats[item.code];
    });
}, { immediate: true });

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-medium text-gray-900">
                Welcome to task management application, {{user.name}}!
            </h2>

            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="item in stats" :key="item.id" class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                    <dt>
                        <div class="absolute rounded-md bg-indigo-500 p-3">
                            <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                        </div>
                        <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>
