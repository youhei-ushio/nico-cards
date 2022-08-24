<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Event;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Entity\Player;

final class Dealt
{
    /**
     * @param Value\Room\Id $roomId
     * @param Player[] $players
     */
    public function __construct(
        private readonly Value\Room\Id $roomId,
        private readonly array $players,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function save(EventRepository $repository): void
    {
        foreach ($this->players as $player) {
            $repository->save(new EventSaveRecord(
                type: Value\Event\Type::fromString('deal'),
                memberId: $player->id,
                roomId: $this->roomId,
                payload: $player->hand,
            ));
        }
    }
}
