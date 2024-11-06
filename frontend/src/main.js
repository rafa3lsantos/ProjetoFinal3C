import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import axios from 'axios';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

axios.defaults.baseURL = 'App\Http\Controllers\CandidateController@store';
axios.defaults.withCredentials = true;


const app = createApp(App);

app.use(router);
app.use(store);

app.config.globalProperties.$axios = axios;

app.mount('#app');
