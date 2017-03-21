
const routes = [
    {
        path: '/admin',
        component (resolve) {
            require(['./components/admin/index.vue'], resolve);
        },
        name: 'admin.index',
        children: [
            {
                path: 'system/menu',
                component (resolve) {
                    require(['./components/admin/system/menu.vue'], resolve);
                },
                name: 'admin.system.menu'
            }
        ]
    }
];
export default routes;
