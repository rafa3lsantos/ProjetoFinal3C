import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store'; // Certifique-se de que o Vuex está sendo importado corretamente
import axios from 'axios';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const app = createApp(App);

app.use(router);
app.use(store); // Certifique-se de que o Vuex está sendo usado

app.config.globalProperties.$axios = axios;

app.mount('#app');
