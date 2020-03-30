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

export default {
    fetchList(context, projectId) {
        return new Promise((resolve, reject) => {
            http.get(`/projects/${projectId}/issues`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
    fetch(context, id) {
        return new Promise((resolve, reject) => {
            http.get(`/issues/${id}`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
    resolve(context, id) {
        return new Promise((resolve, reject) => {
            http.patch(`/issues/${id}/resolve`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
    unresolve(context, id) {
        return new Promise((resolve, reject) => {
            http.patch(`/issues/${id}/unresolve`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
};
