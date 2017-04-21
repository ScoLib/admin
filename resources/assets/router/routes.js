import Parent from '../views/parent.vue'
import Blank from '../views/blank.vue'

export default [
    {
        path: '/admin/login',
        component (resolve) {
            require(['../views/login.vue'], resolve);
        },
        name: 'admin.login',
        meta: {
            title: '登录'
        }
    },
    {
        path: '/admin',
        component: Parent,
        meta: {
            title: '首页'
        },
        children: [
            {
                path: '/',
                component (resolve) {
                    require(['../views/index.vue'], resolve);
                },
                name: 'admin.index',
                meta: {
                    title: '控制台'
                }
            },

            {
                path: 'system',
                component: Blank,
                meta: {
                    title: '系统管理'
                },
                children: [
                    {
                        path: 'menu',
                        component (resolve) {
                            require(['../views/system/menu/index.vue'], resolve);
                        },
                        name: 'admin.system.menu',
                        meta: {
                            title: '菜单管理'
                        },
                    }
                ],
            },
            {
                path: 'manager',
                component: Blank,
                meta: {
                    title: '管理组'
                },
                children: [
                    {
                        path: 'user',
                        component (resolve) {
                            require(['../views/manager/user/index.vue'], resolve);
                        },
                        name: 'admin.manager.user',
                        meta: {
                            title: '管理员'
                        }
                    },
                    {
                        path: 'role',
                        component (resolve) {
                            require(['../views/manager/role/index.vue'], resolve);
                        },
                        name: 'admin.manager.role',
                        meta: {
                            title: '角色管理'
                        }
                    },
                ],
            },
        ],
    }
];
