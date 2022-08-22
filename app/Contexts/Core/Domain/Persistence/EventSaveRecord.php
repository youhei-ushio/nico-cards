<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

final class EventSaveRecord
{
    public function __construct(
        public readonly Value\Event\Type $type,
        public readonly Value\Member\Id|null $memberId,
        public readonly Value\Room\Id|null $roomId,
        public readonly Value\Game\Card|null $card,
    )
    {

    }
}
