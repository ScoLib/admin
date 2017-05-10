import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import store from '../store';

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
    console.log(to);
    console.log(from);
    if (typeof window.LoggedUser != 'undefined') {
        store.commit('setUser', window.LoggedUser);
    }

    if (to.fullPath != '/#') {
        if (to.name != 'admin.login' && Object.keys(store.state.user).length == 0) {
            return next({name: 'admin.login'});
        }
        

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