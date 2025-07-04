<?php

use App\Broadcasting\MessageSentChannel;
use App\Broadcasting\UserRoomChannel;
use App\Broadcasting\UserChannel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('message-sent', MessageSentChannel::class, ['guards' => ['web']]);
Broadcast::channel('user-room', UserRoomChannel::class, ['guards' => ['web']]);
Broadcast::channel('user-event', UserChannel::class, ['guards' => ['web']]);
