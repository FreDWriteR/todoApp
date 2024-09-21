<script setup>
    import { ref, onMounted } from 'vue';
    import { debounce } from 'lodash';
    import axios from 'axios';

    const tasks = ref([]);
    const newTask = ref({ description: '', status: 'todo' });

    const fetchTasks = () => {
        axios.get('/api/tasks').then(response => {
            tasks.value = response.data.map(task => ({ ...task, savedMessage: '' }));
        });
    };

    const addTask = () => {
        axios.post('/api/tasks', newTask.value).then(() => {
            fetchTasks();
            newTask.value.description = '';
        });
    };

    const updateTask = debounce((task) => {
        axios.put(`/api/tasks/${task.id}`, task).then((response) => {
            task.savedMessage = 'SAVED';
            setTimeout(() => {
                task.savedMessage = ''; // Убираем сообщение через 100 мс
            }, 300);
            fetchTasks();
        });
    }, 300);

    const deleteTask = (id) => {
        axios.delete(`/api/tasks/${id}`).then(() => {
            fetchTasks();
        });
    };

    // Метод для определения класса в зависимости от статуса задачи
    const taskClass = (status) => {
        switch (status) {
            case 'done':
                return 'bg-green-100'; // Зелёный
            case 'doing':
                return 'bg-orange-100'; // Оранжевый
            case 'todo':
                return 'bg-yellow-100'; // Желтый ближе к белому
            default:
                return '';
        }
    };

    // Загрузка задач при монтировании компонента
    onMounted(fetchTasks);
</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl mb-4">Менеджер задач</h1>
        <form @submit.prevent="addTask">
            <input v-model="newTask.description" placeholder="New task" class="border rounded p-2 mb-4 w-full" />
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Task</button>
        </form>

        <div class="mt-4">
            <div v-for="task in tasks" :key="task.id" :class="taskClass(task.status)" class="p-4 border rounded mb-4">
                <div class="relative mb-2">
                    <input
                        v-model="task.description"
                        @input="updateTask(task)"
                        class="border rounded p-2 w-full"
                    />
                    <span
                        v-if="task.savedMessage"
                        class="absolute text-green-500 ml-2 text-lg top-1/2 right-1.5 transform -translate-y-1/2 z-10">
                        {{ task.savedMessage }}
                    </span>
                </div>
                <select v-model="task.status" @change="updateTask(task)">
                    <option value="todo">To Do</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                </select>
                <button @click="deleteTask(task.id)" class="bg-red-500 text-white p-2 rounded ml-2">Delete</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
