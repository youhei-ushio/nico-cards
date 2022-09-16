<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Leave;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Notification;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly Notification\Room\Left $left,
        private readonly Notification\Room\LeavingRefused $leavingRefused,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $self = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        if ($roundRecord !== null && !$roundRecord->finished) {
            $this->leavingRefused->dispatch($room, $self);
            return;
        }
        $self->leave();
        $self->save($this->roomMemberRepository);

        $this->left->dispatch($room, $self);
    }
}
