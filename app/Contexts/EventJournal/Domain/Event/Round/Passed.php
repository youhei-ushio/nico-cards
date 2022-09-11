<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Event\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Upcard;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * パスされた
 */
interface Passed
{
    /**
     * @param Value\Room $room
     * @param RoomMember $member
     * @return void
     */
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
