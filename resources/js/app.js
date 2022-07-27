require('./bootstrap');

import { createApp } from 'vue'
import ViewUIPlus from 'view-ui-plus';
import locale from 'view-ui-plus/dist/locale/en-US';
import mainApp from './Components/mainApp.vue';
import Router from './router';
import Store from './store';
import common from './common';

const app = createApp({
    components: {
        mainApp,
    }
});
app.use(ViewUIPlus, {
    locale
});
app.mixin(common);
app.use(Router);
app.use(Store);
app.mount('#app');