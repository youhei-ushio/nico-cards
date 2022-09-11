<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Enter;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Event;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly Event\Room\Entered $entered,
        private readonly Event\Room\EnteringRefused $enteringRefused,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $self = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        if ($self->isIn($room)) {
            // 同じ部屋にいる場合は何もしない
            return;
        }
        if ($room->isFull) {
            $this->enteringRefused->dispatch($room, $self);
            return;
        }
        if (!$self->isInLobby()) {
            // 別な部屋にいる場合は何もしない
            return;
        }

        $self->enter($room);
        $self->save($this->roomMemberRepository);

        $this->entered->dispatch($room, $self);
    }
}
