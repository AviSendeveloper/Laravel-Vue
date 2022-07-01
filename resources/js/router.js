import { createRouter, createWebHistory } from 'vue-router';

import fristPage from './Components/firstPage.vue';
import hooks from './Components/basic/hooks.vue';


const Router = createRouter({
    history: createWebHistory(),
    routes: [
        // Test
        {
            name: 'first',
            path: '/first-route-page',
            component: fristPage,
        },

        // Hooks route
        {
            name: 'hooks',
            path: '/hooks',
            component: hooks,
        }
    ]
});

// Vue.use(Router);

export default Router;