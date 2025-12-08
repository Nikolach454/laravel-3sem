/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

console.log('Initializing Pusher...');

Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1b556ba6211dfb1b901b',
    cluster: 'eu',
    forceTLS: false,
    enableStats: false,
});

console.log('Echo initialized:', window.Echo);
