"use strict";

export default () => {
    let button = document.getElementById('add-filter');
    if (button !== null) {
        button.addEventListener('click', function(event) {
            let html = document.querySelector('.filter-block').cloneNode(true);
            let nodeBefore = document.querySelector('.button-add-filter');

            html.querySelector('.values-input').value = null;
            html.querySelector('.types-input').selectedIndex = 0;

            document.getElementById('filters').insertBefore(html, nodeBefore);
        });
    }
}