<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

interface EventMessageRepository
{
    public function save(EventMessageSaveRecord $record): void;
}
