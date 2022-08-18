<?php

declare(strict_types=1);

namespace App\Contexts\Robby\UseCase\Room\Index;

use App\Core\Domain\Value\Member;
use App\Core\Domain\Value\RoomCollection;

final class Output
{
    public function __construct(
        public readonly RoomCollection $rooms,
        public readonly Member $member,
    )
    {

    }
}
