import { createRouter, createWebHistory } from 'vue-router';

import hooks from './Components/basic/hooks.vue';

import homePage from './Components/admin/home.vue';
import tags from './Components/admin/tags.vue';
import categories from './Components/admin/categories.vue';


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
        {
            name: 'categories',
            path: '/categories',
            component: categories,
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