<?php

use App\Contexts\Core\Domain\Value;
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
    if (Value\Room\Id::lobby()->equals($roomId)) {
        return true;
    }
    return Models\RoomUser::query()
        ->where('user_id', $user->id)
        ->where('room_id', $roomId)
        ->exists();
});

Broadcast::channel('room{roomId}.for{userId}', function ($user, $roomId, $userId) {
    if ($user->id !== $userId) {
        return false;
    }
    if (Value\Room\Id::lobby()->equals($roomId)) {
        return true;
    }
    return Models\RoomUser::query()
        ->where('user_id', $user->id)
        ->where('room_id', $roomId)
        ->exists();
});
