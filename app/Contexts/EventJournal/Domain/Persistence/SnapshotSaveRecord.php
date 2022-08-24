<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

final class SnapshotSaveRecord
{
    public function __construct(
        public readonly int $id,
        public readonly int $roomId,
    )
    {

    }
}
