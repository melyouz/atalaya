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

import JWT from "@/utils/JWT";

export default {
    getAccessToken: state => state.access_token,
    isAccessTokenExpired: state => JWT.isExpired(state.access_token),
    isLoggedIn: state => state.access_token !== null,
    getUser: state => state.user,
}
