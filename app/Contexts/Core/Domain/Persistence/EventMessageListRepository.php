<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;
use Iterator;

interface EventMessageListRepository extends Iterator
{
    /**
     * @param Value\Member\Id $memberId
     * @return void
     */
    public function restore(Value\Member\Id $memberId): void;

    /**
     * @return EventMessageRestoreRecord
     */
    public function current(): EventMessageRestoreRecord;

    /**
     * @return int
     */
    public function key(): int;
}
