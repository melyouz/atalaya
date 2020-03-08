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

import http from "@/http";
import JWT from "@/utils/JWT";
const qs = require('querystring');

export default {
    login(context, credentials) {
        return new Promise((resolve, reject) => {
            http.post("/jwt/token", qs.stringify({
                username: credentials.email,
                password: credentials.password
            }), {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then(response => {
                    const token = response.data.token;
                    const payload = JWT.getPayload(token);

                    context.commit('setAccessToken', token);
                    context.commit('setUser', {
                        id: payload.sub || '',
                        name: payload.user_name || '',
                        email: payload.user_email || '',
                        roles: payload.user_roles || '',
                    });

                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        })
    },
    logout: context => {
        context.commit('destroyAccessToken');
        context.commit('destroyUser');
    },
};
