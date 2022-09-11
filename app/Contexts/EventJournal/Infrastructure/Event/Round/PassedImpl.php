<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Event\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\RoomMember;
use App\Contexts\EventJournal\Domain\Event\Round\Passed;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class PassedImpl implements Passed
{
    public function __construct(
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function dispatch(Value\Room $room, RoomMember $member): void
    {
        foreach ($room->members as $member) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $member->id->getValue(),
                $room->id->getValue(),
                __('game.round.passed', ['name' => $member->name->getValue()]),
                Value\Event\Message\Level::info()->getValue(),
            ));
        }

        event(new class($room, $member) implements ShouldBroadcastNow
        {
            use Dispatchable, InteractsWithSockets;

            public function __construct(
                private readonly Value\Room $room,
                public readonly Value\Member $member,
            )
            {

            }

            public function broadcastOn(): array|Channel|PrivateChannel|string
            {
                return new PrivateChannel("room{$this->room->id}");
            }

            public function broadcastAs(): string
            {
                return 'room.changed';
            }
        });
    }
}
