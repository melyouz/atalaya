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

import Login from '../views/Login'
import Logout from '../views/Logout'

export default [
    {
        path: '/users/login',
        name: 'users-login',
        component: Login,
        meta: {
            guestOnly: true
        }
    },
    {
        path: '/users/logout',
        name: 'users-logout',
        component: Logout
    },
];
