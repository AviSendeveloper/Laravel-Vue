import { createRouter, createWebHistory } from 'vue-router';
import Store from './store';

import hooks from './Components/basic/hooks.vue';
import master from './vuex_test/master.vue';

// Main Admin Component
import homePage from './Components/admin/home.vue';
import tags from './Components/admin/tags.vue';
import categories from './Components/admin/categories.vue';
import AdminUser from './Components/admin/admin_user.vue';
import AdminLogin from './Components/admin/admin_login.vue';
import roles from './Components/admin/roles.vue';
import roleAssign from './Components/admin/roleAssign.vue';


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
        {
            name: 'admin_user',
            path: '/admin-user',
            component: AdminUser,
        },
        {
            name: 'login',
            path: '/',
            component: AdminLogin,
        },
        {
            name: 'roles',
            path: '/roles',
            component: roles,
        },
        {
            name: 'role_assign',
            path: '/role-assign',
            component: roleAssign,
        },

        // Hooks route
        {
            name: 'hooks',
            path: '/hooks',
            component: hooks,
        },
        {
            name: 'master',
            path: '/master',
            component: master,
        }
    ]
});

Router.beforeEach((to, from, next) => {
    let userStatus = Store.state.isUserLoggedin;
    
    if (userStatus && (to.name === 'login')) {
        next({ name: 'home' });
    }
    else if (userStatus == false && (to.name !== 'login')) {
        next({ name: 'login' });
    }
    else {
        next();
    };
});

// Vue.use(Router);

export default Router;