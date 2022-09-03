<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\UseCase\Room\Enter;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Lobby\Domain\Event\Entered;

final class Interactor
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    )
    {

    }

    /**
     * @param Input $input
     * @return void
     */
    public function execute(Input $input): void
    {
        $event = new Entered(
            memberId: $input->memberId,
            roomId: $input->roomId,
        );
        $event->save($this->eventRepository);
    }
}
