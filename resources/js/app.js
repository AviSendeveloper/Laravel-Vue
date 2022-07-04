require('./bootstrap');

import { createApp } from 'vue'
import ViewUIPlus from 'view-ui-plus';
import mainApp from './Components/mainApp.vue';
import Router from './router';
import common from './common';

const app = createApp({
    components: {
        mainApp,
    }
});
app.use(ViewUIPlus);
app.mixin(common);
app.use(Router)
app.mount('#app');