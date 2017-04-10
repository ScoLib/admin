require('jquery');

require('bootstrap');
require('./ace/script');


import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import ElementUI from 'element-ui';

// import iView from 'iview';
// import 'iview/dist/styles/iview.css';

import routes from './routes';
import App from './components/App.vue';
import store from './store/';
import filters from './filters/';
// import Loading from './loading';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(ElementUI);
Vue.use(filters);

// Vue.use(iView);
// Vue.use(Loading);

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    // console.log(from);
    // console.log(to);
    // iView.LoadingBar.start();
    if (to.fullPath != '/#') {
        next();
    }
});

router.afterEach((to, from, next) => {
    // iView.LoadingBar.finish();
});


Vue.component(
    'FormGroup',
    require('./components/FormGroup.vue')
);
const app = new Vue(Vue.util.extend({router, store}, App)).$mount('#app');
