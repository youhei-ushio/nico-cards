<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Event\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * 退室が拒否された
 */
interface LeavingRefused
{
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
