<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Event\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * カードを場に出せなかった
 */
interface PlayingCanceled
{
    /**
     * @param Value\Room $room
     * @param RoomMember $member
     * @return void
     */
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
