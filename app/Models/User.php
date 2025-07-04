<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;

class User extends Authenticatable
{
    use BroadcastsEvents, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The events that should be broadcasted.
     *
     * @var array
     */
    public function broadcastOn(string $event): array
    {
        return [new PrivateChannel('user-event')];
    }

    /* by default event name is model name then event type like 
    .UserCreated
    .UserUpdated
    .UserDeleted
    .UserRestored
    .UserTrashed
    */
    public function broadcastAs(string $event): string|null
    {
        return match ($event) {
            'created' => 'newUserCreated',
            'updated' => 'UserUpdated',
            'deleted' => 'UserDeleted',
            'restored' => 'UserRestored',
            'trashed' => 'UserTrashed',
            default => null,
        };
    }

    public function broadcastWith(string $event): array
    {
    return match ($event) {
    'created' => ['user name' => $this->name,'user email' => $this->email],
    default => ['model' => $this],
    };
    }

}
