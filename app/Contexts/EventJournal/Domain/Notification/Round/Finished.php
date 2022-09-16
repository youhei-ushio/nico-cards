<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Notification\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;

/**
 * ラウンドを開始した
 */
interface Finished
{
    /**
     * @param Value\Room $room
     * @param Round $round
     * @return void
     */
    public function dispatch(Value\Room $room, Round $round): void;
}
