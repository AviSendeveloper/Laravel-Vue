import { createRouter, createWebHistory } from 'vue-router';

import fristPage from './Components/firstPage.vue';
import hooks from './Components/basic/hooks.vue';

import homePage from './Components/pages/home.vue';
import tags from './Components/pages/tags.vue';


const Router = createRouter({
    history: createWebHistory(),
    routes: [
        // Project pages
        {
            name: 'home',
            path: '/home',
            component: homePage,
        },
        {
            name: 'tags',
            path: '/tags',
            component: tags,
        },
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