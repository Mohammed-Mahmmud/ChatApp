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

