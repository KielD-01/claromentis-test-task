import axios from 'axios';
import Vue from "vue";
import VueAxios from "vue-axios";

const http = axios.create({
    baseURL: '/api'
});

Vue.use(VueAxios, http);