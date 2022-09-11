<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\UseCase\Room\Index;

use App\Contexts\Core\Domain\Value;

final class Output
{
    public function __construct(
        public readonly Value\RoomCollection $rooms,
        public readonly Value\Member $member,
    )
    {

    }
}
