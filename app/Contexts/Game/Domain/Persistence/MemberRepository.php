<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Persistence;

use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * メンバーのリポジトリ
 */
interface MemberRepository
{
    /**
     * @param Value\Member\Id $id
     * @return MemberRestoreRecord
     */
    public function restore(Value\Member\Id $id): MemberRestoreRecord;
}
