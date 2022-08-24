<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Event;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Contexts\Core\Domain\Value;

final class Played
{
    /**
     * @param Value\Member\Id $memberId
     * @param Value\Room\Id $roomId
     * @param array $cards
     */
    public function __construct(
        private readonly Value\Member\Id $memberId,
        private readonly Value\Room\Id $roomId,
        private readonly array $cards,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function save(EventRepository $repository): void
    {
        $repository->save(new EventSaveRecord(
            type: Value\Event\Type::fromString('play'),
            memberId: $this->memberId,
            roomId: $this->roomId,
            payload: $this->cards,
        ));
    }
}
