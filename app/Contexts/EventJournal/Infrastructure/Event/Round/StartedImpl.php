<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Event\Round;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Event\Round\Started;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class StartedImpl implements Started
{
    public function __construct(
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function dispatch(Value\Room $room, Round $round): void
    {
        foreach ($room->members as $member) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $member->id->getValue(),
                $room->id->getValue(),
                __('game.round.started'),
                Value\Event\Message\Level::info()->getValue(),
            ));
        }
        $this->eventMessageRepository->save(new EventMessageSaveRecord(
            Value\Member\Id::everyone()->getValue(),
            $room->id->getValue(),
            __('game.round.started_in', ['room' => $room->name]),
            Value\Event\Message\Level::info()->getValue(),
        ));

        event(new class($room->id) implements ShouldBroadcastNow
        {
            use Dispatchable, InteractsWithSockets;

            public function __construct(
                private readonly Value\Room\Id $roomId,
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
