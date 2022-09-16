<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Pass;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Notification;
use App\Contexts\EventJournal\Domain\Exception\CannotPassException;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly Notification\Round\Passed $passed,
        private readonly Notification\Round\PassingCanceled $passingCanceled,
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
            $round->pass();
        } catch (CannotPassException) {
            $this->passingCanceled->dispatch($room, $member);
            return;
        }
        $round->save($this->roundRepository);

        $this->passed->dispatch($room, $member);
    }
}
