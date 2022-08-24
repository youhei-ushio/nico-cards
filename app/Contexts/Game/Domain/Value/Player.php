<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Value;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;

/**
 * プレイヤー（自分）
 */
final class Player
{
    /**
     * @param Value\Member\Id $id メンバーID
     * @param Value\Member\Name $name メンバー名
     * @param bool $onTurn ターン中かどうか
     * @param Value\Game\Card[] $hand 手札
     */
    private function __construct(
        public readonly Value\Member\Id $id,
        public readonly Value\Member\Name $name,
        public readonly bool $onTurn,
        public readonly array $hand,
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
            hand: array_map(function (CardRestoreRecord $record) {
                return Value\Game\Card::restore($record);
            }, $record->hand),
        );
    }
}
