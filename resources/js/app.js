require('./bootstrap');

import { createApp } from 'vue'
import mainApp from './Components/mainApp.vue';
import { createRouter, createWebHistory } from 'vue-router';
import fristPage from './Components/firstPage.vue';

const Router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/first-route-page',
            component: fristPage,
            name: 'first'
        }
    ]
});

const app = createApp({
    components: { 
        mainApp,
        fristPage
    }
});
app.use(Router);
app.mount('#app');