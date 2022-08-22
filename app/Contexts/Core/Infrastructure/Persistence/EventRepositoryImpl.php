<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\EventRepository;
use App\Contexts\Core\Domain\Persistence\EventSaveRecord;
use App\Models;
use Throwable;

final class EventRepositoryImpl implements EventRepository
{
    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function save(EventSaveRecord $record): void
    {
        (new Models\Journal())
            ->fill([
                'type' => $record->type,
                'user_id' => $record->memberId?->getValue(),
                'room_id' => $record->roomId?->getValue(),
                'suit' => $record->card?->suit,
                'number' => $record->card?->number,
            ])
            ->saveOrFail();
    }
}
