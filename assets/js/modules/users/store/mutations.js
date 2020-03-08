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

export default {
    setAccessToken: (state, access_token) => {
        localStorage.setItem("access_token", access_token);
        state.access_token = access_token;
    },
    destroyAccessToken: state => {
        localStorage.removeItem("access_token");
        state.access_token = null;
    },
    setUser: (state, user) => {
        localStorage.setItem("user", JSON.stringify(user));
        state.user = user;
    },
    destroyUser: state => {
        localStorage.removeItem("user");
        state.user = null;
    },
};
