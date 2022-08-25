<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * 進行中ラウンドのリポジトリ
 */
interface RoundRepository
{
    /**
     * @param Value\Member\Id $memberId
     * @return RoundRestoreRecord|null
     */
    public function restore(Value\Member\Id $memberId): RoundRestoreRecord|null;

    /**
     * @param RoundSaveRecord $record
     * @return void
     */
    public function save(RoundSaveRecord $record): void;
}
