<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Notification\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * 部屋に入室した
 */
interface Entered
{
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
