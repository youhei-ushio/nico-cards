<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Domain\Event;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Contexts\Core\Domain\Value;

final class Left implements Value\Event
{
    public function __construct(
        private readonly Value\Member\Id $memberId,
        private readonly Value\Room\Id $roomId,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function save(EventRepository $repository): void
    {
        $repository->save(new EventSaveRecord(
            type: Value\Event\Type::fromString('leave'),
            memberId: $this->memberId,
            roomId: $this->roomId,
            payload: null,
        ));
    }
}
