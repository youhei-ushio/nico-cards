<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Replay;

use App\Contexts\Core\Domain\Value;

final class Input
{
    public function __construct(
        public readonly Value\Room\Id $roomId,
    )
    {

    }
}
