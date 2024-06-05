<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskList from "@/Components/Task/TaskList.vue";
import Button from "primevue/button";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import TaskStore from "@/Components/Task/TaskStore.vue";
import Message from 'primevue/message';


const statusOptions = ref([
    { label: 'Pending', value: 'pending' },
    { label: 'Completed', value: 'completed' }
]);

const newTask = ref({
    title: '',
    description: ''
});

const tasks = ref([]);

const nextPageUrl = ref(null);
const prevPageUrl = ref(null);
const url = ref(null);

const expandedTaskIds = ref([]);

const toggleExpand = (taskId) => {
    if (expandedTaskIds.value.includes(taskId)) {
        expandedTaskIds.value = expandedTaskIds.value.filter(id => id !== taskId);
    } else {
        expandedTaskIds.value.push(taskId);
    }
};

const isTaskExpanded = (taskId) => {
    return expandedTaskIds.value.includes(taskId);
};

const fetchTasks = async (apiUrl) => {
    url.value = apiUrl;
    await axios.get(apiUrl)
        .then(response => {
            tasks.value = response.data.data;
            nextPageUrl.value = response.data.next_page_url;
            prevPageUrl.value = response.data.prev_page_url;
        })
        .catch(error => {
            console.log(error);
        });
};



const deleteSubtask = async (taskId, subtaskId) => {
    if (confirm("Are you sure you want to remove?")) {
        // isSubmitting.value = true
        router.delete(route(`tasks.destroy`, { task: taskId, subtask: subtaskId }), {
            preserveScroll: true,
            onSuccess: () => {
                fetchTasks(url.value);
                // notify('Disconnected successfully', 'Success')
            },
            // onFinish: () => isSubmitting.value = false
        });
    }
}

const showTaskDialog = ref(false);
const isEditTaskDialog = ref(false);
const activeParentTask = ref(null);

const createChildTask = (payload) => {
    console.log('create child task');
    const {task, isEdit} = payload;
    console.log(task, isEdit);
    showTaskDialog.value = true;
    isEditTaskDialog.value = isEdit;
    activeParentTask.value = task;
}

const hideCreatePopup = () => {
    showTaskDialog.value = false;
    isEditTaskDialog.value = false;
    activeParentTask.value = null;
}

const callback = () => {
    fetchTasks(url.value || route('tasks.index'));
}

onMounted(async () => {
    await fetchTasks(route('tasks.index'));
});

</script>

<template>
    <AppLayout title="Tasks">
        <div class="p-6">
            <div class="flex justify-between mb-6">
                <h2 class="text-2xl font-bold mb-4">Task List</h2>
                <Button label="Add Task" @click="showTaskDialog = true" icon="pi pi-plus" />
            </div>

            <Message v-if="tasks.length === 0" severity="info">There are no task.</Message>
            <TaskList v-else :tasks="tasks" @createTask="createChildTask" @callback="callback"/>

            <TaskStore :isOpen="showTaskDialog" :isEdit="isEditTaskDialog" :parent="activeParentTask" @hide="hideCreatePopup" @callback="callback"/>

        </div>
    </AppLayout>
</template>
