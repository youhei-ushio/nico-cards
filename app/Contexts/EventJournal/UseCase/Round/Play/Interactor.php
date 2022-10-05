<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Play;

use App\Contexts\Core\Domain\Exception\InvalidCombinationException;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Notification;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly Notification\Round\Played $played,
        private readonly Notification\Round\Finished $finished,
        private readonly Notification\Round\PlayingCanceled $playingCanceled,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        $round = Round::restore($roundRecord);
        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $member = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        try {
            $upcard = $round->play($journal->memberId, $journal->cards);
        } catch (CannotPlayCardException | InvalidCombinationException) {
            $this->playingCanceled->dispatch($room, $member);
            return;
        }
        $round->save($this->roundRepository);

        $this->played->dispatch($room, $member, $upcard);
        if ($round->isFinished()) {
            $this->finished->dispatch($room, $round);
        }
    }
}
