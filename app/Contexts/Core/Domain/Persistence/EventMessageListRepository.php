<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use Iterator;

interface EventMessageListRepository extends Iterator
{
    /**
     * @return EventMessageRestoreRecord
     */
    public function current(): EventMessageRestoreRecord;

    /**
     * @return int
     */
    public function key(): int;
}
