require('jquery');

require('bootstrap');
require('./ace/script');


import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import routes from './routes';
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import App from './components/App.vue';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(iView);


const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start();
    next();
});

router.afterEach((to, from, next) => {
    iView.LoadingBar.finish();
});

new Vue(Vue.util.extend({router}, App)).$mount('#app');