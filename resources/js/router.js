// import Vue from 'vue';
import { createApp } from 'vue'
import vueRouter from 'vue-route';
Vue.use(vueRouter);

import fristPage from 'Component/firstPage.vue';


const Router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: 'first-route-page',
            component: {fristPage},
        }
    ]
});


export default new Router({
    mode: 'history',
});