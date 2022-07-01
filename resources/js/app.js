require('./bootstrap');

import { createApp } from 'vue'
import mainApp from './Components/mainApp.vue';
import Router from './router';

const app = createApp({
    components: {
        mainApp,
    }
});
app.use(Router)
app.mount('#app');