

import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import axios from "axios";

axios.defaults.baseURL = "http://RetiredEmployees.test/app"; // Base API URL

const app = createApp(App);
app.use(router);
app.config.globalProperties.$axios = axios;
app.mount('#app');

