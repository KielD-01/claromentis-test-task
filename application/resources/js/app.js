import Vue from 'vue';
import Application from "./components/Application";
import vuetify from "./plugins/vuetify";
import {router} from "./plugins/routes";

import './plugins/http/axios/http.js';

new Vue({
    router,
    vuetify,
    render: h => h(Application),
})
    .$mount('#app');