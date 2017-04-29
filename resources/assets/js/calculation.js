"use strict";

import Request from "./request";

class Calculation {
    constructor(action, method = 'POST', id = 0) {
        this.action = action;
        this.method = method;
        this.id = id
    }

    removeFromTable() {
        new Request(this.action, this.method, () => {
            document.getElementById('calculation-' + this.id).remove();
        }).confirmRequest();
    }

    save(form) {
        let body = new FormData(form);
        new Request(this.action, this.method, () => {
            window.location.replace('/calculations');
        }, body).manageEntity();
    }
}

export default Calculation;