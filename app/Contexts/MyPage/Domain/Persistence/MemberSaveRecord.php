<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Domain\Persistence;

use App\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see MemberRepository::save
 */
final class MemberSaveRecord
{
    public function __construct(
        public readonly Value\Member\Id $id,
        public readonly Value\Member\Name $name,
    )
    {

    }
}
