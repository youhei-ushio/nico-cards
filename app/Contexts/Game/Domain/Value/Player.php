<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Value;

use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * プレイヤー（自分）
 */
final class Player
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Member\Name $name
     * @param Value\Member[] $opponents
     * @see restore()
     */
    private function __construct(
        public readonly Value\Member\Name $name,
        public readonly array $opponents,
    )
    {

    }

    /**
     * 永続化されたエンティティを復元する
     *
     * @param PlayerRestoreRecord $record
     * @return self
     */
    public static function restore(PlayerRestoreRecord $record): self
    {
        $opponents = [];
        foreach ($record->roomRecord->members as $member) {
            if ($member->id->equals($record->id)) {
                continue;
            }
            $opponents[] = $member;
        }

        return new self(
            name: $record->name,
            opponents: $opponents,
        );
    }
}
