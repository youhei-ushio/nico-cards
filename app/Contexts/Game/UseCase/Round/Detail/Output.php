<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Round\Detail;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Value\Round;

final class Output
{
    public function __construct(
        public readonly Value\Member $member,
        public readonly Value\Room $room,
        public readonly Round|null $round,
    )
    {

    }
}
