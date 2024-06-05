<template>
    <div>
        <div v-for="task in tasks" :key="task.id" class="p-4 border rounded-lg mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span v-if="task.sub_tasks.length" @click="toggleExpand(task.id)" class="cursor-pointer mr-2">
                        <i :class="isTaskExpanded(task.id) ? 'pi pi-chevron-down' : 'pi pi-chevron-right'"></i>
                    </span>
                    <p class="text-lg font-semibold">{{ task.title }}</p>
                </div>
                <div class="flex flex-wrap">
                    <select v-model="task.status" @change="changeStatus($event, task.id)" name="status" class="mr-2 border-none h-10" id="">
                        <option value="todo">Todo</option>
                        <option value="in_progress">In progress</option>
                        <option value="done">Done</option>
                    </select>
                    <Button icon="pi pi-pen-to-square" @click="editTask(task)" severity="warning" class=" h-10 mb-2 mr-2" />
                    <Button icon="pi pi-trash" @click="deleteTask(task.id)" severity="danger" class=" h-10 mb-2 mr-2" />
                    <Button icon="pi pi-plus" @click="addTask(task)" severity="default" class="border h-10 mb-2" />
                </div>
            </div>

            <div v-if="isTaskExpanded(task.id)" class="ml-6">
                <TaskList :tasks="task.sub_tasks" @createTask="$emit('createTask', $event)" @callback="$emit('callback')"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from "primevue/button";
import {router} from "@inertiajs/vue3";
import {useToast} from "primevue/usetoast";

const toast = useToast();

const props = defineProps({
    tasks: {
        type: Array,
        required: true
    },
    callback: Function,
    createTask: Function
});

const $emits = defineEmits(['createTask', 'callback']);

const expandedTaskIds = ref([]);

const changeStatus = (event, taskId) => {
    const status = event.target.value;
    router.put(route('tasks.update', { task: taskId }), {status}, {
        preserveScroll: true,
        onSuccess: () => {
            $emits('callback');
            toast.add({severity: 'success', summary: 'Task status updated successfully', life: 3000});
            // alert('Task status updated successfully')
        },

    });
};

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

const deleteTask = (taskId) => {
    if (confirm("Are you sure you want to delete this task?")) {
        router.delete(route('tasks.destroy', { task: taskId }), {
            preserveScroll: true,
            onSuccess: () => {
                toast.add({severity: 'success', summary: 'Task deleted successfully', life: 3000});
                $emits('callback');
            }
        });
    }
};

const addTask = (task) => {
    $emits('createTask', {task, isEdit: false});
}
const editTask = (task) => {
    $emits('createTask', {task, isEdit: true});
}
</script>

<style scoped>
/* Add any necessary styles */
</style>
