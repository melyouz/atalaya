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

export default class JWT
{
    static isExpired(jwt) {
        if (!jwt) return true;

        const payload = JWT.getPayload(jwt);
        const now =  parseInt((Date.now() / 1000).toString());
        const graceTime = 60 * 60 * 2; //2 hours

        return payload.exp - graceTime <= now;
    };

    static getPayload(jwt) {
        if (!jwt) return null;

        const jwtParts = jwt.split('.');
        if (jwtParts.length !== 3) return null;

        const jwtEncodedPayload = jwtParts[1];

        return JSON.parse(atob(jwtEncodedPayload));
    };
}
