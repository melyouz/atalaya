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

import moment from 'moment-timezone'

export default (value) => moment(String(value)).tz('Europe/Madrid').format('DD-MMM-YYYY HH:mm:ss z');
