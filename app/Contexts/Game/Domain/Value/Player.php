<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Value;

use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Core\Domain\Value;

/**
 * プレイヤー
 */
final class Player
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Member\Name $name
     * @param Value\Room $room
     * @see restore()
     */
    private function __construct(
        public readonly Value\Member\Name $name,
        public readonly Value\Room $room,
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
        return new self(
            name: $record->name,
            room: Value\Room::restore($record->roomRecord),
        );
    }
}
