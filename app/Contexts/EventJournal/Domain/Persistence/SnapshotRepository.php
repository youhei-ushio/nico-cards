<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

interface SnapshotRepository
{
    public function save(SnapshotSaveRecord $record): void;
}
