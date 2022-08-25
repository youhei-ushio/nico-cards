<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Create;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Player;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        if ($roundRecord !== null) {
            // すでに対戦中の場合は何もしない
            return;
        }

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $players = Player::createList($room->members);
        $round = Round::create($room, $players);
        $round->save($this->roundRepository);
    }
}
