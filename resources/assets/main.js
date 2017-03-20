require('jquery');

require('bootstrap');
require('./ace/script');


import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import {Message,Modal} from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(VueRouter);
Vue.use(Message);
Vue.use(Modal);


const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

new Vue({
    router
}).$mount('#main-container');
