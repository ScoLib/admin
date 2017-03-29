require('jquery');

require('bootstrap');
require('./ace/script');


import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import iView from 'iview';
import 'iview/dist/styles/iview.css';

import routes from './routes';
import App from './components/App.vue';
import store from './store/';
import filters from './filters/';
import Loading from './loading';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(iView);
Vue.use(Loading);

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

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
Vue.http.credientials = true;

const app = new Vue(Vue.util.extend({router, store, filters}, App)).$mount('#app');
