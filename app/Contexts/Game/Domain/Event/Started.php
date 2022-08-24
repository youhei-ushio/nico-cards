<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Event;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Contexts\Core\Domain\Value;

final class Started
{
    /**
     * @param Value\Room\Id $roomId
     * @param Value\Member\Id $memberId
     */
    public function __construct(
        private readonly Value\Room\Id $roomId,
        private readonly Value\Member\Id $memberId,
    )
    {

    }

    /**
     * @param EventRepository $repository
     * @return void
     */
    public function save(EventRepository $repository): void
    {
        $repository->save(new EventSaveRecord(
            type: Value\Event\Type::fromString('start'),
            memberId: $this->memberId,
            roomId: $this->roomId,
            payload: null,
        ));
    }
}
