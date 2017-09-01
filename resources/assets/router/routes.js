import Vue from 'vue'
import UrlPrefix from '../util/url-prefix'
import Layout from '../components/layout'

Vue.use(UrlPrefix);

let prefix = Vue.getUrlPrefix();

export default [
    {
        path: `/${prefix}/login`,
        component (resolve) {
            require(['../views/login.vue'], resolve);
        },
        name: 'admin.login',
        meta: {
            title: '登录',
            auth: false,
        },
    },
    {
        path: `/${prefix}/403`,
        component (resolve) {
            require(['../views/errors/403.vue'], resolve);
        },
        name: 'admin.403',
        meta: {
            title: '403 Forbidden',
            auth: false,
        },
    },
    {
        path: `/${prefix}`,
        component: Layout,
        children: [
            {
                path: '/',
                component (resolve) {
                    require(['../views/dashboard.vue'], resolve);
                },
                name: 'admin.dashboard',
                meta: {
                    title: '控制台',
                    auth: true,
                }
            },
            {
                path: `500`,
                component (resolve) {
                    require(['../views/errors/500.vue'], resolve);
                },
                name: 'admin.500',
                meta: {
                    title: '500 Error Page',
                    auth: false,
                    msg: '',
                },
            },
            {
                path: 'logs',
                component (resolve) {
                    require(['../views/system/log/index.vue'], resolve);
                },
                name: 'admin.logs',
                meta: {
                    title: '操作日志',
                    auth: true,
                },
            },
            {
                path: ':model/:id/edit',
                component (resolve) {
                    require(['../views/model/edit.vue'], resolve);
                },
                name: 'admin.model.edit',
                meta: {
                    auth: true,
                    title: '编辑',
                },
            },
            {
                path: ':model/create',
                component (resolve) {
                    require(['../views/model/create.vue'], resolve);
                },
                name: 'admin.model.create',
                meta: {
                    auth: true,
                    title: '创建',
                },
            },
            {
                path: ':model',
                component (resolve) {
                    require(['../views/model/index.vue'], resolve);
                },
                name: 'admin.model.index',
                meta: {
                    auth: true,
                    title: '',
                }
            },
        ],
    }
];
