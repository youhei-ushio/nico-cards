<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Notification\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Upcard;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * カードを場に出した
 */
interface Played
{
    /**
     * @param Value\Room $room
     * @param RoomMember $member
     * @param Upcard $upcard
     * @return void
     */
    public function dispatch(Value\Room $room, RoomMember $member, Upcard $upcard): void;
}
