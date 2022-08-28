<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

interface RoomEventMessageListRepository extends EventMessageListRepository
{
    /**
     * @param Value\Member\Id $memberId
     * @param Value\Room\Id $roomId
     * @return void
     */
    public function restore(Value\Member\Id $memberId, Value\Room\Id $roomId): void;
}
