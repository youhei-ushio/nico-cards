<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Notification\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * 部屋に再入室した
 */
interface ReEntered
{
    public function dispatch(RoomMember $member): void;
}
