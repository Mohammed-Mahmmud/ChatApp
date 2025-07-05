// Reverb Settings
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// window.Pusher = Pusher;
// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY, // ← يجب أن يكون REVERB وليس PUSHER
//     wsHost: window.location.hostname, // أو استخدم 127.0.0.1 إذا أردت
//     wsPort: 8080,
//     wssPort: 8080,
//     forceTLS: false,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
//     // إذا استخدمت REVERB_PATH في .env أضف:
//     // path: '/reverb',
// });


window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') == 'https',
    enabledTransports: ['ws', 'wss'],
    });