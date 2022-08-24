<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Round\Play;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Event\Played;
use App\Contexts\Game\Domain\Persistence\RoomRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomRepository $roomRepository,
        private readonly EventRepository $eventRepository,
    )
    {

    }

    public function execute(Input $input): void
    {
        $room = Value\Room::restore($this->roomRepository->restore($input->memberId));
        $event = new Played(
            memberId: $input->memberId,
            roomId: $room->id,
            cards: $input->cards,
        );
        $event->save($this->eventRepository);
    }
}
