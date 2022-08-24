<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Value;

use App\Contexts\Core\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * プレイヤー（対戦相手）
 */
final class Opponent
{
    /**
     * @param Value\Member\Id $id メンバーID
     * @param Value\Member\Name $name メンバー名
     * @param bool $onTurn ターン中かどうか
     * @param int $hand 手札（枚数のみ）
     */
    private function __construct(
        public readonly Value\Member\Id $id,
        public readonly Value\Member\Name $name,
        public readonly bool $onTurn,
        public readonly int $hand,
    )
    {

    }

    /**
     * @param PlayerRestoreRecord $record
     * @return self
     */
    public static function restore(PlayerRestoreRecord $record): self
    {
        return new self(
            id: Value\Member\Id::fromNumber($record->id),
            name: Value\Member\Name::fromString($record->name),
            onTurn: $record->onTurn,
            hand: count($record->hand),
        );
    }
}
