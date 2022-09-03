<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

interface EventMessageRepository
{
    /**
     * イベント登録
     *
     * @param EventMessageSaveRecord $record
     * @return void
     */
    public function save(EventMessageSaveRecord $record): void;
}
