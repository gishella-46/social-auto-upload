import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

const app = createApp(App);

// Tambahkan Axios ke global scope
app.config.globalProperties.$http = axios;

// Gunakan router
app.use(router);

// Mount ke elemen HTML dengan id "app"
app.mount('#app');
