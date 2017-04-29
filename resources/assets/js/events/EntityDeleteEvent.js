"use strict";

import Calculation from "./../calculation";

/**
 * Events for delete buttons.
 */
export default () => {
    document.querySelectorAll('.calculation-delete').forEach(element => {
        element.addEventListener('click', event => {
            new Calculation('/calculations/' + element.dataset.id, 'DELETE', element.dataset.id).removeFromTable();
        })
    });
}