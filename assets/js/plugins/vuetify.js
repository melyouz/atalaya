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
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
            light: {
                primary: '#00796B', //teal-700
                secondary: '#00897B', // teal-600
                accent: '#3f51b5', // teal-900
                error: '#f44336',
                warning: '#ff5722',
                info: '#03a9f4',
                success: '#4caf50',
            }
            /*light: {
                primary: '#009688',
                secondary: '#607d8b',
                accent: '#3f51b5',
                error: '#f44336',
                warning: '#ff5722',
                info: '#03a9f4',
                success: '#4caf50',
            }*/
        }
    }
}

export default new Vuetify(opts)
