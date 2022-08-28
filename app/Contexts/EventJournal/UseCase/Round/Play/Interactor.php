<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Play;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly EventMessageRepository $eventMessageRepository,
        private readonly RoomRepository $roomRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        $round = Round::restore($roundRecord);
        try {
            $upcard = $round->play($journal->memberId, $journal->cards);
        } catch (CannotPlayCardException) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                $journal->roomId->getValue(),
                __('game.round.cannot_play_card'),
                Value\Event\Message\Level::error()->getValue(),
            ));
            return;
        }
        $round->save($this->roundRepository);

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        foreach ($room->members as $member) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $member->id->getValue(),
                $journal->roomId->getValue(),
                __('game.round.played', ['name' => $journal->memberName->getValue(), 'card' => $upcard->toString()]),
                Value\Event\Message\Level::info()->getValue(),
            ));
        }
    }
}
