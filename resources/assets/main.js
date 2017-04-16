require('jquery');
require('bootstrap');
require('./ace/script');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import VueI18n from 'vue-i18n';
import ElementUI from 'element-ui';

import routes from './routes';
import locales from './lang';
import App from './components/App.vue';
import store from './store/';
import filters from './filters/';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(VueI18n);
Vue.use(ElementUI);
Vue.use(filters);

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    // console.log(to);
    // console.log(from);

    if (to.fullPath != '/#') {
        let title = 'Sco Admin';
        if (to.meta.title) {
            title = to.meta.title + ' - ' + title;
        }
        document.title = title;
        next();
    }
});

Object.keys(locales).forEach(function (lang) {
    Vue.locale(lang, locales[lang]);
});
Vue.config.lang = window.Lang;

Vue.component(
    'FormGroup',
    require('./components/FormGroup.vue')
);

const app = new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');
