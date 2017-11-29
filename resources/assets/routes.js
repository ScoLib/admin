import Vue from 'vue'
import UrlPrefix from './util/url-prefix'
import Layout from './components/layouts/index.vue'

Vue.use(UrlPrefix);

let prefix = Vue.getUrlPrefix();

let extRoutes = [];
// import extRoutes from '../../js/routes'

let defRoutes = [
    {
        path: '/',
        component (resolve) {
            require(['./components/views/dashboard.vue'], resolve);
        },
        name: 'admin.dashboard',
        meta: {
            title: '控制台',
        }
    },
    {
        path: `/${prefix}/403`,
        component (resolve) {
            require(['./components/views/error.vue'], resolve);
        },
        name: 'admin.403',
        meta: {
            title: '403 Forbidden',
        },
    },
    {
        path: '404',
        component (resolve) {
            require(['./components/views/error.vue'], resolve);
        },
        name: 'admin.404',
        meta: {
            title: '404 Not Found',
        },
    },
    {
        path: `500`,
        component (resolve) {
            require(['./components/views/error.vue'], resolve);
        },
        name: 'admin.500',
        meta: {
            title: '500 Error Page',
        },
    },
    {
        path: ':model/:id/edit',
        component (resolve) {
            require(['./components/views/model/edit.vue'], resolve);
        },
        name: 'admin.model.edit',
        meta: {
            title: '编辑',
        },
    },
    {
        path: ':model/create',
        component (resolve) {
            require(['./components/views/model/create.vue'], resolve);
        },
        name: 'admin.model.create',
        meta: {
            title: '创建',
        },
    },
    {
        path: ':model',
        component (resolve) {
            require(['./components/views/model/index.vue'], resolve);
        },
        name: 'admin.model.index',
        meta: {
            title: '',
        }
    },
];

let children = extRoutes.concat(defRoutes)

export default [
    {
        path: `/${prefix}/login`,
        component (resolve) {
            require(['./components/layouts/login.vue'], resolve);
        },
        name: 'admin.login',
        meta: {
            title: '登录',
        },
    },
    {
        path: `/${prefix}`,
        component: Layout,
        children: children,
    }
];
