<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Start;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Event;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
        private readonly Event\Round\Started $started,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $round = Round::restore($this->roundRepository->restore($journal->memberId));
        $round->start();
        $round->save($this->roundRepository);

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $this->started->dispatch($room, $round);
    }
}
