<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * プレイヤーリポジトリ
 */
interface PlayerRepository
{
    /**
     * @return PlayerRestoreRecord
     */
    public function restore(Value\Member\Id $id): PlayerRestoreRecord;
}
