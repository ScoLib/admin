window.$ = window.jQuery = require('jquery');

import axios from 'axios';
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

require('bootstrap');
require('jquery-slimscroll');
window.AdminLTE = require('./admin.js');


import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes';

const router = new VueRouter({
    routes,
    mode: 'history'
});

new Vue({
    router
}).$mount('.wrapper');
