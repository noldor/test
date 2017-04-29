"use strict";

import {default as swal} from "sweetalert2";
import RequestException from "./requestexception";
import StatusCodes from "./StatusCodesRussian";
import 'whatwg-fetch';

class Request {
    /**
     * @constructor
     * @param {string} url
     * @param {string} method
     * @param {callback} callback
     * @param {FormData} body
     */
    constructor(url, method = 'POST', callback = null, body = null) {
        this.url = url;
        this.method = method;
        this.callback = callback;
        this.data = body;
        this.csrf = window.Laravel.csrfToken;
    }

    /**
     * Make a simple ajax request.
     *
     * @return {Promise}
     */
    simpleRequest() {
        return fetch(this.url, {
            headers: new Headers({
                "X-CSRF-TOKEN": this.csrf,
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
                "X-CSRF-TOKEN": this.csrf,
                "Accept": "application/json"
            },
            body: this.data,
            // Not work with PUT or PATCH methods even in chrome.
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
            this.removeErrors();
            // Create notification and invoke custom callback.
            swal({
                title: 'Выполнено!',
                type: 'success',
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
                swal({
                    title: StatusCodes.hasOwnProperty(exception.getStatus()) ? StatusCodes[exception.getStatus()].call() : 'Что-то пошло нет так! Попробуйте позже.',
                    type: 'error'
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
            let form = document.getElementById('main-form');
            let errorsList = document.getElementById('errors-list');
            for (let error in json) {
                if (json.hasOwnProperty(error)) {
                    let message = json[error];
                    form.querySelector('[name="' + error + '"]').parentElement.parentElement.classList.add("has-error");
                    let newError = document.createElement('li');
                    newError.innerHTML = message;
                    errorsList.appendChild(newError);
                }
            }
            errorsList.parentElement.classList.remove('hidden');
        })
    }

    /**
     * Remove all errors from html.
     */
    removeErrors() {
        let form = document.getElementById('main-form');
        form.querySelectorAll('input, textarea').forEach(element => {
            element.parentElement.parentElement.classList.remove("has-error")
        });
        document.getElementById('errors-list').parentElement.classList.add('hidden');
    }

    /**
     * Call confirmation swal and then make ajax request for entity deleting.
     */
    confirmRequest() {
        // Create alert.
        swal({
            title: 'Вы уверены?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Да, сделаем это!',
            cancelButtonText: 'Подумаю еще!'
        }).then(() => {
            this.simpleRequest().then(response => {
                    if (!response.ok) {
                        //Instantiate an exception if response not successful.
                        throw new RequestException(response);
                    }
                }
            ).then(() => {
                this.callback.call()
                swal({
                    title: 'Выполнено!',
                    type: 'success',
                    timer: 2000
                }).catch(swal.noop)
            }).catch(exception => {
                    swal({
                        title: StatusCodes.hasOwnProperty(exception.getStatus()) ? StatusCodes[exception.getStatus()].call() : 'Что-то пошло нет так! Попробуйте позже.',
                        type: 'error'
                    });
                });
        }, () => {
            // We do not need delete entity.
            swal({
                title: 'Отменено!',
                type: 'error',
                timer: 1000
            }).catch(swal.noop);
        })
    }
}

export default Request;