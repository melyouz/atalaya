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

import axios from 'axios'
import store from './store'
import router from './router'

let http = axios.create({
    baseURL: '/api',
    headers: {'Content-Type': 'application/json'},
});

http.interceptors.request.use(
    function (config) {
        const token = store.getters['users/getAccessToken'];

        if (token) config.headers.Authorization = `Bearer ${token}`;

        return config
    },
    function (error) {
        return Promise.reject(error)
    }
);

http.interceptors.response.use(
    response => response,
    function (error) {
        if (error.response && error.response.status === 401) {
            store.dispatch('users/logout').then(() => router.push({name: 'users-login'}));
        }

        return Promise.reject(error);
    }
);

export default http
