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

// Pusher Commercial Settings
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// Laravel WebSockets Settings
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
    disableStats: true,
});
// Model event broadcasting
window.Echo.private('message-sent')
.listen('.message-sent', (data) => {
    console.log('Message received:', data);
}).listen('.comment-sent', (e) => {
    console.log('Comment received:', e);
});

// Model Broadcasting
window.Echo.private(`user-event`)
.listen('.newUserCreated', (data) => {
    console.log('New User created:', data);
});

// Dropdown logic
document.addEventListener('DOMContentLoaded', function() {
    const usersBtn = document.getElementById('current-users-btn');
    const usersUl = document.getElementById('current-users');
    let currentUsers = [];

    // Toggle dropdown
    usersBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        usersUl.classList.toggle('hidden');
    });
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!usersUl.classList.contains('hidden')) {
            if (!usersUl.contains(e.target) && !usersBtn.contains(e.target)) {
                usersUl.classList.add('hidden');
            }
        }
    });
    // Prevent closing when clicking inside
    usersUl.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Render users in dropdown
    function renderUsers(users) {
        usersUl.innerHTML = '';
        users.forEach(user => {
            let name = user.name || user.id || JSON.stringify(user);
            const li = document.createElement('li');
            li.className = 'px-4 py-2 hover:bg-blue-100';
            li.textContent = name;
            usersUl.appendChild(li);
        });
    }

    window.Echo.join('user-room')
        .here((users) => {
            console.log('Users in the room:', users);
            currentUsers = users;
            renderUsers(currentUsers);
        })
        .joining((user) => {
            console.log('User joined:', user);
            currentUsers.push(user);
            renderUsers(currentUsers);
        })
        .leaving((user) => {
            console.log('User left:', user);
            currentUsers = currentUsers.filter(u => u.id !== user.id);
            renderUsers(currentUsers);
        })
        .error((error) => {
            console.error('Error in user-room:', error);
        });
});

window.Echo.channel(`public-message`)
.listen('.public-message-event', (data) => {
    console.log('print message:', data);
});

