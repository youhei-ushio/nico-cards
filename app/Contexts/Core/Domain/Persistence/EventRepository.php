<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

interface EventRepository
{
    /**
     * @param EventSaveRecord $record
     * @return void
     */
    public function save(EventSaveRecord $record): void;
}
