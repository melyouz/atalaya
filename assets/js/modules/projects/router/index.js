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

import ProjectsList from '../views/ProjectsList'

export default [
    {
        path: '/projects',
        name: 'projects-list',
        component: ProjectsList,
        meta: {
            authRequired: true
        }
    },
];
