<?php

declare(strict_types=1);

namespace App\Core\Domain\Persistence;

use App\Core\Domain\Value;

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
