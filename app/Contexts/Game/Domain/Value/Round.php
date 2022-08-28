<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Value;

use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Domain\Value\Member\Id;
use App\Contexts\Game\Domain\Exception\RoundNotFoundException;

/**
 * 対戦ラウンド
 */
final class Round
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Game\Upcard|null $upcard 場札
     * @param Value\Game\Round\Turn $turn ターン
     * @param bool $reversed 革命による反転中かどうか
     * @param Player $player プレイヤー（自分）
     * @param Opponent[] $opponents プレイヤー（対戦相手）
     * @param bool $finished 終了したかどうか
     * @see restore()
     */
    private function __construct(
        public readonly Value\Game\Upcard|null $upcard,
        public readonly Value\Game\Round\Turn $turn,
        public readonly bool $reversed,
        public readonly Player $player,
        public readonly array $opponents,
        public readonly bool $finished,
    )
    {

    }

    /**
     * @param Id $memberId
     * @param RoundRestoreRecord|null $record
     * @return self|null
     */
    public static function restore(Value\Member\Id $memberId, RoundRestoreRecord|null $record): self|null
    {
        if ($record === null) {
            return null;
        }

        $player = null;
        $opponents = [];
        foreach ($record->playerRecords as $playerRecord) {
            if ($playerRecord->id === $memberId->getValue()) {
                $player = Player::restore($playerRecord);
            } else {
                $opponents[] = Opponent::restore($playerRecord);
            }
        }
        if ($player === null) {
            throw new RoundNotFoundException();
        }
        return new self(
            upcard: Value\Game\Upcard::restore($record->upcard),
            turn: Value\Game\Round\Turn::fromNumber($record->turn),
            reversed: $record->reversed,
            player: $player,
            opponents: $opponents,
            finished: $record->finished,
        );
    }
}
