<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

final class JournalRestoreRecord
{
    public function __construct(
        public readonly Value\Event\Id $id,
        public readonly Value\Event\Type $type,
        public readonly Value\Room\Id|null $roomId,
        public readonly Value\Member\Id|null $memberId,
        public readonly Value\Game\Card|null $card,
    )
    {

    }
}
