import { createApp } from 'vue';
import axios from 'axios';
import App from './components/App.vue';
import router from './router';
import store from './store';

axios.defaults.baseURL = 'http://127.0.0.1:8000';

const app = createApp(App);

// Use the router
app.use(router);

// Add the store to the app
app.use(store);

// Mount the app
app.mount('#app');
