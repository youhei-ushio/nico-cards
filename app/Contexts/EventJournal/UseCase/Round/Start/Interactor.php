<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Start;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $round = Round::restore($this->roundRepository->restore($journal->memberId));
        $round->start();
        $round->save($this->roundRepository);

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        foreach ($room->members as $member) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $member->id->getValue(),
                __('game.round.started'),
                Value\Event\Message\Level::info()->getValue(),
            ));
        }
    }
}
