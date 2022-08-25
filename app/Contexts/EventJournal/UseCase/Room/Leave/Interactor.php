<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Room\Leave;

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
        private readonly RoundRepository $roundRepository,
        private readonly RoomMemberRepository $roomMemberRepository,
        private readonly RoomRepository $roomRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        if ($roundRecord !== null) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                __('lobby.room.cannot_leave_round'),
                Value\Event\Message\Level::error()->getValue(),
            ));
            return;
        }

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $self = RoomMember::restore($this->roomMemberRepository->restore($journal->memberId));
        $self->leave();
        $self->save($this->roomMemberRepository);

        foreach ($room->members as $member) {
            if ($self->equals($member)) {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $journal->id->getValue(),
                    $journal->memberId->getValue(),
                    __('lobby.room.left_self', ['room' => $room->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            } else {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $journal->id->getValue(),
                    $member->id->getValue(),
                    __('lobby.room.left', ['name' => $self->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            }
        }
    }
}
