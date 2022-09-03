<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class MessagePosted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        private readonly int $roomId,
        public readonly string $message,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function broadcastOn(): array|Channel|PrivateChannel|string
    {
        return new PrivateChannel("room$this->roomId");
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'message.posted';
    }
}
