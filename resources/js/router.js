import { createRouter, createWebHistory } from 'vue-router';

import fristPage from './Components/firstPage.vue';


const Router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'first',
            path: '/first-route-page',
            component: fristPage,
        }
    ]
});

// Vue.use(Router);

export default Router;