<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

interface EventRepository
{
    /**
     * @param EventSaveRecord $record
     * @return void
     */
    public function save(EventSaveRecord $record): void;

    /**
     * @return void
     */
    public function waitForLastEvent(): void;

    /**
     * @return Value\Event\Id|null
     */
    public function lastEventId(): Value\Event\Id|null;

    /**
     * @param Value\Event\Id|null $eventId
     */
    public function proceeded(Value\Event\Id|null $eventId): bool;
}
