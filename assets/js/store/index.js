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

import Vue from 'vue';
import Vuex from 'vuex';
import users from '@modules/users/store';
import projects from '@modules/projects/store';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        users,
        projects,
    },
    state: {
        snackMessage: ''
    },
    actions: {},
    getters: {
        getSnackMessage: state => state.snackMessage,
    },
    mutations: {
        setSnackMessage: (state, snackMessage) => {
            state.snackMessage = snackMessage
        },
    },
});
