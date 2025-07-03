<?php

namespace App\Broadcasting;

use App\Models\User;

class MessageSentChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        return true;
        // return $user->exists; // Allow access if the user exists in the database
    }
}
