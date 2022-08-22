<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value;

use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;

/**
 * メンバー
 */
final class Member
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Member\Id $id
     * @param Member\Name $name
     * @param Member\Email $email
     * @see restore()
     */
    private function __construct(
        public readonly Member\Id $id,
        public readonly Member\Name $name,
        public readonly Member\Email $email,
    )
    {

    }

    /**
     * 永続化された値オブジェクトを復元する
     *
     * @param MemberRestoreRecord $record
     * @return self
     */
    public static function restore(MemberRestoreRecord $record): self
    {
        return new self(
            id: $record->id,
            name: $record->name,
            email: $record->email,
        );
    }
}
