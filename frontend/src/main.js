import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import axios from 'axios';
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";



import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const app = createApp(App);

app.use(router);
app.use(store);


app.config.globalProperties.$axios = axios;

app.mount('#app');
