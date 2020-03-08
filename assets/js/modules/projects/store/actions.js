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

const API_PATH = '/projects';

export default {
    fetchList(context) {
        return new Promise((resolve, reject) => {
            http.get(API_PATH)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
    create(context, project) {
        return new Promise((resolve, reject) => {
            http.post(API_PATH, project)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        });
    },
    edit(context, project) {
        return new Promise((resolve, reject) => {
            http.patch(`${API_PATH}/${project.id}`, project)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        });
    },
    archive(context, projectId) {
        return new Promise((resolve, reject) => {
            http.patch(`${API_PATH}/${projectId}/archive`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
    unarchive(context, projectId) {
        return new Promise((resolve, reject) => {
            http.patch(`${API_PATH}/${projectId}/unarchive`)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        })
    },
};
