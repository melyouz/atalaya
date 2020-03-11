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
import router from './router'
import store from './store'
import http from './http'
import App from './App.vue'

import DateTimeFilter from './filters/DateTimeFilter'

import vuetify from './plugins/vuetify'
import Gravatar from 'vue-gravatar';
import VueClipboard from 'vue-clipboard2';

// Vue filters
Vue.filter('date', DateTimeFilter);

// Vue plugins
Vue.prototype.$http = http;
Vue.component('v-gravatar', Gravatar);
Vue.use(VueClipboard);

// App
new Vue({
    vuetify,
    el: '#vue-app',
    router,
    store,
    template: '<app/>',
    components: {App}
});

// Images
// const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
// imagesContext.keys().forEach(imagesContext);
