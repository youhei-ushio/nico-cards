<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Notification\Room;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Notification\Room\ReEntered;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class ReEnteredImpl implements ReEntered
{
    public function dispatch(RoomMember $member): void
    {
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
                return new PrivateChannel("room$this->roomId.for$this->memberId");
            }

            public function broadcastAs(): string
            {
                return 'room.changed';
            }
        });
    }
}
