/*
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'
import NotFound from '@/views/NotFound';

import usersRoutes from '@modules/users/router';
import projectsRoutes from '@modules/projects/router';
import issuesRoutes from '@modules/issues/router';

Vue.use(VueRouter);

const baseRoutes = [
    {
        path: '/',
        name: 'homepage',
        redirect: {name: 'issues-list'},
        //component: Home,
        meta: {
            'authRequired': true
        }
    },
    {
        path: '404',
        name: '404',
        component: NotFound
    },
    {
        path: '*',
        name: 'catchall',
        component: NotFound
    }
];

const routes = baseRoutes.concat(usersRoutes, projectsRoutes, issuesRoutes);

const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve({x: 0, y: 0})
            }, 500)
        })
    }
});

router.beforeEach((to, from, next) => {
    if (store.getters['users/getAccessToken'] && store.getters['users/isAccessTokenExpired']) {
        store.dispatch('users/logout');
    }

    const isLoggedIn = store.getters['users/isLoggedIn'];

    if (to.matched.some(record => record.meta.authRequired) && !isLoggedIn) {
        next({
            name: 'users-login',
            params: {nextUrl: to.fullPath}
        })
    } else if (to.matched.some(record => record.meta.guestOnly) && isLoggedIn) {
        next({name: 'homepage'})
    } else {
        next()
    }
});

export default router
