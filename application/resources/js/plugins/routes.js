import Vue from "vue";
import VueRouter from 'vue-router';

import HelpComponent from "../components/HelpComponent";
import MainComponent from "../components/MainComponent";
import UploadComponent from "../components/UploadComponent";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: MainComponent, name: 'main'},
    {path: '/upload', component: UploadComponent, name: 'upload'},
    {path: '/help', component: HelpComponent, name: 'help'},
    {path: '/:catchAll(.*)', component: MainComponent, name: 'NotFound'}
];

export const router = new VueRouter({
    mode: 'history',
    routes
});