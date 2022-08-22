<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

use App\Contexts\Core\Domain\Value;

/**
 * リポジトリで利用するDTO
 *
 * @see MemberRepository::restore
 */
final class MemberRestoreRecord
{
    public function __construct(
        public readonly Value\Member\Id $id,
        public readonly Value\Member\Name $name,
        public readonly Value\Member\Email $email,
    )
    {

    }
}
