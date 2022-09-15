<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Event\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Event\Room\Left;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class LeftImpl implements Left
{
    public function __construct(
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function dispatch(Value\Room $room, RoomMember $member): void
    {
        foreach ($room->members as $roomMember) {
            if ($member->equals($roomMember)) {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $member->id->getValue(),
                    $room->id->getValue(),
                    __('lobby.room.left_self', ['room' => $room->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            } else {
                $this->eventMessageRepository->save(new EventMessageSaveRecord(
                    $roomMember->id->getValue(),
                    $room->id->getValue(),
                    __('lobby.room.left', ['name' => $member->name]),
                    Value\Event\Message\Level::info()->getValue(),
                ));
            }
        }

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

        event(new class(Value\Room\Id::lobby(), $member->id) implements ShouldBroadcastNow
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
