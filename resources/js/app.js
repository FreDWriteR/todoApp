import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import TaskList from './components/TaskList.vue';

createApp(TaskList).mount('#app');
