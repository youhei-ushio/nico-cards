<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Persistence;

/**
 * リポジトリで利用するDTO
 *
 * @see MemberRepository::restore
 */
final class MemberRestoreRecord
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    )
    {

    }
}
