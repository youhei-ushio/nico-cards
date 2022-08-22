<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

interface EventRepository
{
    public function save(EventSaveRecord $record): void;
}
