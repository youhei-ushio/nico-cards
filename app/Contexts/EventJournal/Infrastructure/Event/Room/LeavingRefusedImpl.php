<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Event\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Event\Room\LeavingRefused;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class LeavingRefusedImpl implements LeavingRefused
{
    public function __construct(
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function dispatch(Value\Room $room, RoomMember $member): void
    {
        $this->eventMessageRepository->save(new EventMessageSaveRecord(
            $member->id->getValue(),
            $room->id->getValue(),
            __('lobby.room.cannot_leave_round'),
            Value\Event\Message\Level::error()->getValue(),
        ));

        event(new class($room->id, $member->id) implements ShouldBroadcastNow
        {
            use Dispatchable, InteractsWithSockets;

            public function __construct(
                private readonly Value\Room\Id $roomId,
                public readonly Value\Member\Id $memberId,
            )
            {

            }

            public function broadcastOn(): array|Channel|PrivateChannel|string
            {
                return new PrivateChannel("room$this->roomId");
            }

            public function broadcastAs(): string
            {
                return 'room.changed';
            }
        });
    }
}
