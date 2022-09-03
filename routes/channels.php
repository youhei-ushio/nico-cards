<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models;

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

Broadcast::channel('room{roomId}', function ($user, $roomId) {
    return Models\RoomUser::query()
        ->where('user_id', $user->id)
        ->where('room_id', $roomId)
        ->exists();
});
