<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Notification\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Domain\Value\Room;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;

/**
 * ラウンド作成ができなかった
 */
interface CreatingCanceled
{
    /**
     * @param Room $room
     * @param RoomMember $member
     * @return void
     */
    public function dispatch(Value\Room $room, RoomMember $member): void;
}
