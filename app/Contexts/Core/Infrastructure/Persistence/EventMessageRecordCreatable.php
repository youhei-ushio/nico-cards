<?php

declare(strict_types=1);

namespace App\Contexts\Core\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Domain\Persistence\EventMessageRestoreRecord;

trait EventMessageRecordCreatable
{
    private function createEventMessageRecord(array $row): EventMessageRestoreRecord
    {
        $id = Value\Event\Id::fromNumber($row['id']);
        $occurredAt = Value\Event\OccurredDateTime::fromString($row['created_at']);
        $body = Value\Event\Message\Body::fromString($row['body']);
        $level = Value\Event\Message\Level::fromString($row['level']);
        return new EventMessageRestoreRecord(
            id: $id,
            occurredAt: $occurredAt,
            body: $body,
            level: $level,
        );
    }
}
