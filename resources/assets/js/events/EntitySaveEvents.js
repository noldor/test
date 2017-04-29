"use strict";

import Calculation from "./../calculation";

/**
 * Events for save button and submit form for entity save and update.
 */
export default () => {
    let form = document.getElementById('main-form');
    if (form !== null) {
        document.getElementById('calculation-save').addEventListener('click', event => {
            new Calculation(form.getAttribute('action'), 'POST', form.querySelector('[name="_method"]').value).save(form);
        });

        form.addEventListener('onsubmit', event => {
            event.preventDefault();
            new Calculation(form.getAttribute('action'), form.querySelector('[name="_method"]').value).save(form);
        });
    }
}