"use strict";

import {default as swal} from "sweetalert2";
import RequestException from "./requestexception";

class Request {
    /**
     * @constructor
     * @param {string} url
     * @param {string}method
     * @param {callback} callback
     * @param {FormData} body
     */
    constructor(url, method = 'POST', callback = null, body = null) {
        this.url = url;
        this.method = method;
        this.callback = callback;
        this.data = body;
    }

    /**
     * Make a simple ajax request.
     *
     * @return {Promise}
     */
    simpleRequest() {
        return fetch(this.url, {
            headers: new Headers({
                "X-CSRF-TOKEN": window.Laravel.csrfToken,
                "Accept": "application/json"
            }),
            method: this.method,
            mode: 'same-origin',
            credentials: 'same-origin',
            cache: 'no-cache'
        });
    }

    /**
     * Make request for store or updating entity in database.
     */
    manageEntity() {
        fetch(this.url, {
            headers: {
                "X-CSRF-TOKEN": window.Laravel.csrfToken,
                "Accept": "application/json"
            },
            body: this.data,
            // Not work with PUT or PATCH methods
            method: 'POST',
            mode: 'same-origin',
            credentials: 'same-origin',
            cache: 'no-cache'
        }).then(response => {
            if (!response.ok) {
                //Instantiate an exception if response not successful.
                throw new RequestException(response);
            }
        }).then(() => {
            // Create notification and invoke custom callback.
            swal({
                title: 'Выполнено!',
                timer: 2000
            }).then(() => {
                this.callback.call();
            }, () => {
                this.callback.call();
            });
        }).catch(exception => {
            // Exception handling and error rendering if we have errors with validation.
            if (exception.hasValidationErrors()) {
                this.renderErrors(exception.getValidationErrors());
            } else {
                // Undefined error, show notification.
                swal({
                    title: 'Что-то пошло нет так! Попробуйте позже.',
                    timer: 2000
                });
            }
        });
    }

    /**
     * Render errors on page.
     *
     * @param {Promise} data
     */
    renderErrors(data) {
        data.then(json => {
            for (let error in json) {
                if (json.hasOwnProperty(error)) {
                    let message = json[error];
                    console.log(error);
                    console.log(message);
                }
            }
        })
    }

    /**
     * Call confirmation swal and then make ajax request for entity deleting.
     */
    confirmRequest() {
        // Create alert.
        swal({
            title: 'Вы уверены?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Да, сделаем это!',
            cancelButtonText: 'Подумаю еще!'
        }).then(() => {
            swal({
                title: 'Выполнено!',
                type: 'success',
                timer: 2000
            }).then(
                // Call entity deleting request and invoke custom callback.
                () => {
                    this.simpleRequest();
                    this.callback.call()
                }
            );
        }, () => {
            // We do not need delete entity.
            swal({
                title: 'Отменено!',
                type: 'error',
                timer: 2000
            });
        })
    }
}

export default Request;