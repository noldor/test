"use strict";

class RequestException {
    /**
     * @constructor
     *
     * @param response
     */
    constructor(response) {
        this.response = response;
    }

    /**
     * Get response promise.
     *
     * @returns Promise
     */
    getResponse() {
        return this.response;
    }

    /**
     * Get response status.
     *
     * @public
     * @return {number}
     */
    getStatus() {
        return this.response.status;
    }

    /**
     * Get response status text.
     *
     * @return {string}
     */
    getMessage() {
        return this.response.statusText;
    }

    /**
     * Determine if response has validation errors.
     *
     * @return {boolean}
     */
    hasValidationErrors() {
        return (this.getStatus() === 422 && this.getMessage() === 'Unprocessable Entity');
    }

    /**
     * Return promise with validation errors.
     *
     * @return {*}
     */
    getValidationErrors() {
        return this.response.json();
    }
}

export default RequestException;