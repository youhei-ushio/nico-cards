<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Enter;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        if ($room->isFull) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                __('lobby.room.room_is_full', ['name' => $room->name]),
                Value\Event\Message\Level::error()->getValue(),
            ));
            return;
        }

        $self = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        if ($self->isIn($room)) {
            // 同じ部屋にいる場合は何もしない
            return;
        }
        if (!$self->isInLobby()) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                __('lobby.room.leave_first'),
                Value\Event\Message\Level::error()->getValue(),
            ));
            return;
        }

        $self->enter($room);
        $self->save($this->roomMemberRepository);

        foreach ($room->members as $member) {
            if ($self->equals($member)) {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $journal->id->getValue(),
                    $journal->memberId->getValue(),
                    __('lobby.room.entered_self', ['room' => $room->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            } else {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $journal->id->getValue(),
                    $member->id->getValue(),
                    __('lobby.room.entered', ['name' => $self->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            }
        }
    }
}
