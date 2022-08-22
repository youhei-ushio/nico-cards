<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Journal;

final class EventMessageSaveRecord
{
    public function __construct(
        public readonly Journal $journal,
        public readonly Value\Event\Message\Body $body,
        public readonly Value\Event\Message\Level $level,
    )
    {

    }
}
