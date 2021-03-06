import Vue from 'vue';
import "./mixins/global";
import 'simplebar';
import axios from 'axios';
axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded';
import axiosMethodOverride from 'axios-method-override';
axiosMethodOverride(axios);
const instance = axios.create();
axiosMethodOverride(instance);
import store from "./store";
import Main from '../vue/main.vue';
import Router from './router';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);
__webpack_public_path__ = PINOOX.URL.THEME + 'dist/';

new Vue({
    el: '#app',
    render: h => h(Main),
    router: Router,
    store: store,
});