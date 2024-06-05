<script setup>
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Textarea from "primevue/textarea";
import InputText from "primevue/inputtext";
import {router, useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {useToast} from "primevue/usetoast";

const toast = useToast();


const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
        required: true
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
    parent: {
        type: Object,
        default: null
    }
});

const $emits = defineEmits(['hide', 'callback']);

const form = useForm({
    parent_id: '',
    title: '',
    description: '',
    status: 'todo',
});

watch(() => props.isEdit, (value) => {
    if (value) {
        form.title = props.parent.title;
        form.description = props.parent.description;
        form.status = props.parent.status;
    }
});

const addTask = async () => {
    // update or store
    if (props.isEdit) {
        form.put(route('tasks.update', {task: props.parent.id}),  {
            preserveScroll: true,
            onSuccess: () => {
                // alert('Task created successfully')
                toast.add({severity: 'success', summary: 'Task updated successfully', life: 3000});
                // toast.add({ severity: 'success', summary: 'Success Message', detail: 'Message Content', life: 3000 });

                $emits('hide');
                $emits('callback');
            },
            onFinish: () => {
                // enabling.value = false;
                // confirming.value = props.requiresConfirmation;
            },
        });
    } else {
        if (props.parent) {
            form.parent_id = props.parent.id;
        }
        form.post(route('tasks.store'),  {
            preserveScroll: true,
            onSuccess: () => {
                // alert('Task created successfully')
                toast.add({severity: 'success', summary: 'Task created successfully', life: 3000});
                // toast.add({ severity: 'success', summary: 'Success Message', detail: 'Message Content', life: 3000 });

                $emits('hide');
                $emits('callback');
            },
            onFinish: () => {
                // enabling.value = false;
                // confirming.value = props.requiresConfirmation;
            },
        });
    }
};

const visible = ref(false);

watch(() => props.isOpen, (value) => {
    visible.value = value;
});
watch(() => visible.value, (value) => {
    if (!value) {
        form.reset();
        $emits('hide');
    }
});

</script>

<template>
    <Dialog v-model:visible="visible" :header="(isEdit ? 'Edit ' : '' ) + 'Add Task' + (parent ? ' for ' + parent.title : '')" :closeOnEscape="true">
        <form @submit.prevent="addTask">
            <div class="grid">
                <InputText v-model="form.title" placeholder="Task Title" class="mb-2" />
            </div>
            <div class="grid">
                <Textarea v-model="form.description" placeholder="Task Description" class="mb-2" />
            </div>
            <div class="grid mb-3">
                <select name="" v-model="form.status" class="border-gray-300" id="">
                    <option value="todo">Todo</option>
                    <option value="in_progress">In progress</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="grid">
                <Button v-if="isEdit" :label="form.processing ? 'Updating...' : 'Update Task'" :disabled="form.processing" @click="addTask" class="p-button-success" />
                <Button v-else :label="form.processing ? 'Creating...' : 'Add Task'" :disabled="form.processing" @click="addTask" class="p-button-success" />
            </div>
        </form>
    </Dialog>
</template>

<style scoped>

</style>
