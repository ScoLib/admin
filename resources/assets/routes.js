import Parent from './views/parent.vue'

const routes = [
    {
        path: '/admin',
        component (resolve) {
            require(['./views/index.vue'], resolve);
        },
        name: 'admin.index'
    },
    {
        path: '/admin/system/menu',
        component (resolve) {
            require(['./views/system/menu/index.vue'], resolve);
        },
        name: 'admin.system.menu'
    },
    {
        path: '/admin/manager/user',
        component (resolve) {
            require(['./views/manager/user/index.vue'], resolve);
        },
        name: 'admin.manager.user'
    },
    {
        path: '/admin/manager/role',
        component (resolve) {
            require(['./views/manager/role/index.vue'], resolve);
        },
        name: 'admin.manager.role',
        title: '角色管理',
    },
    {
        path: '/admin/manager/role/create',
        component (resolve) {
            require(['./views/manager/role/create.vue'], resolve);
        },
        name: 'admin.manager.role.create'
    }
];
// export default routes;

export default [
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
                    require(['./views/index.vue'], resolve);
                },
                name: 'admin.index',
                meta: {
                    title: '控制台'
                }
            },
            {
                path: 'system',
                component: Parent,
                meta: {
                    title: '系统管理'
                },
                children: [
                    {
                        path: 'menu',
                        component (resolve) {
                            require(['./views/system/menu/index.vue'], resolve);
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
                component: Parent,
                meta: {
                    title: '管理组'
                },
                children: [
                    {
                        path: 'user',
                        component (resolve) {
                            require(['./views/manager/user/index.vue'], resolve);
                        },
                        name: 'admin.manager.user',
                        meta: {
                            title: '管理员'
                        }
                    },
                    {
                        path: 'role',
                        component (resolve) {
                            require(['./views/manager/role/index.vue'], resolve);
                        },
                        name: 'admin.manager.role',
                        meta: {
                            title: '角色管理'
                        },
                        children: [
                            {
                                path: 'create',
                                component (resolve) {
                                    require(['./views/manager/role/create.vue'], resolve);
                                },
                                name: 'admin.manager.role.create',
                                meta: {
                                    title: '创建角色'
                                },
                            }
                        ],
                    }
                ],
            }
        ],
    }
];
