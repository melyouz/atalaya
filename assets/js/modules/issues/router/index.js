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

import IssuesList from '../views/IssuesList'
import IssueDetail from '../views/IssueDetail'

export default [
    {
        path: '/issues',
        name: 'issues-list',
        component: IssuesList,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/projects/:projectId/issues',
        name: 'project-issues-list',
        component: IssuesList,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/issues/:id',
        name: 'issue-detail',
        component: IssueDetail,
        meta: {
            authRequired: true
        }
    }
];
