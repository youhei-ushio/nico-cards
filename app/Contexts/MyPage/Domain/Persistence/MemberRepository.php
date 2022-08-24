<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Domain\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;

/**
 * メンバーリポジトリ
 */
interface MemberRepository
{
    /**
     * @param Value\Member\Id $id
     * @return MemberRestoreRecord
     */
    public function restore(Value\Member\Id $id): MemberRestoreRecord;

    /**
     * @param MemberSaveRecord $record
     */
    public function save(MemberSaveRecord $record): void;
}
