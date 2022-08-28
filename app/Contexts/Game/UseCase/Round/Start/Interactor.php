<?php

declare(strict_types=1);

namespace App\Contexts\Game\UseCase\Round\Start;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Game\Domain\Entity\Dealer;
use App\Contexts\Game\Domain\Entity\Player;
use App\Contexts\Game\Domain\Event\Created;
use App\Contexts\Game\Domain\Event\Started;
use App\Contexts\Game\Domain\Persistence\RoomRepository;
use App\Contexts\Game\Domain\Persistence\RoundRepository;
use App\Contexts\Game\Domain\Event\Dealt;

final class Interactor
{
    public function __construct(
        private readonly RoomRepository $roomRepository,
        private readonly RoundRepository $roundRepository,
        private readonly EventRepository $eventRepository,
        private readonly Dealer $dealer,
    )
    {

    }

    public function execute(Input $input): void
    {
        $roundRecord = $this->roundRepository->restore($input->memberId);
        if ($roundRecord !== null && !$roundRecord->finished) {
            // すでに対戦中の場合は何もしない
            return;
        }

        $room = Value\Room::restore($this->roomRepository->restore($input->memberId));
        $players = Player::createList($room->members);

        $startEvent = new Created(
            roomId: $room->id,
            memberId: $input->memberId,
        );
        $startEvent->save($this->eventRepository);

        $dealEvent = new Dealt(
            roomId: $room->id,
            players: $this->dealer->deal($players),
        );
        $dealEvent->save($this->eventRepository);

        $startEvent = new Started(
            roomId: $room->id,
            memberId: $input->memberId,
        );
        $startEvent->save($this->eventRepository);
        $this->eventRepository->waitForLastEvent();
    }
}
