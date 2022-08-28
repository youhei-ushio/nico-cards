<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 * @see EventMessageRepository::save()
 */
final class EventMessageSaveRecord
{
    public function __construct(
        public readonly int $journalId,
        public readonly int $memberId,
        public readonly int $roomId,
        public readonly string $body,
        public readonly string $level,
    )
    {

    }
}
