<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Domain\Persistence;

use App\Core\Domain\Persistence\MemberRepository as MemberValueRepository;

/**
 * メンバーリポジトリ
 */
interface MemberRepository extends MemberValueRepository
{
    /**
     * @param MemberSaveRecord $record
     */
    public function save(MemberSaveRecord $record): void;
}
