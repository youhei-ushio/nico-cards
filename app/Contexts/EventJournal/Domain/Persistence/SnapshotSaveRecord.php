<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 * @see EventMessageRepository::save()
 */
final class SnapshotSaveRecord
{
    public function __construct(
        public readonly int $id,
        public readonly int $roomId,
    )
    {

    }
}
