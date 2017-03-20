
const routes = [
    {
        path: '/admin',
        component (resolve) {
            require(['./components/admin/index.vue'], resolve);
        },
        name: 'Hello'
    }
];
export default routes;
