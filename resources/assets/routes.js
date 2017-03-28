
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
    }
];
export default routes;
