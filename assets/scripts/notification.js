/**
 * Notification using Boostrap Toasts and Mercure Hub
 */

import '../styles/notification.css';

import {Toast} from 'bootstrap/dist/js/bootstrap.esm.min.js'

const options = {'animation': true, 'autohide': true, 'delay': 5000};

new EventSource(document.getElementById("notifications").dataset.url).onmessage = event => {
    try {
        const node = document.getElementById("toast-prototype").cloneNode(true);
        node.id = event.lastEventId.replaceAll(':', '-');
        document.getElementById("notifications-container").appendChild(node);

        const payload = JSON.parse(event.data);

        const nodeSelector = document.querySelector('#' + node.id);

        const header = nodeSelector.querySelector('.toast-header');
        header.classList.add('bg-' + (payload.type ?? 'primary'));
        header.querySelector('.toast-title').innerHTML = payload.title;

        nodeSelector.querySelector('.toast-body').innerHTML = payload.message;

        new Toast(node, options).show()
    } catch (e) {
        console.error(e);
    }
}
