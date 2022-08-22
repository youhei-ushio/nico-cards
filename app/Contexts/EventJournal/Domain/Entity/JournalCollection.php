<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity;

use Iterator;

/**
 * イベントジャーナル一覧
 */
interface JournalCollection extends Iterator
{
    /**
     * @return Journal
     */
    public function current(): Journal;

    /**
     * @return int
     */
    public function key(): int;
}
