import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || { x: 0, y: 0 }
    }
});

//路由开始前
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


//路由完成后
router.afterEach(route => {

});

export default router;