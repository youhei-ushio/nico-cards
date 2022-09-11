<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Event\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * 部屋から退室した
 */
interface Left
{
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
