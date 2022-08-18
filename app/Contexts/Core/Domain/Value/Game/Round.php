<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Value;

/**
 * ゲームのラウンド
 */
final class Round
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Value\Room $room 部屋
     * @param Card[] $upcards 場札
     * @param bool $reversed 革命による反転中かどうか
     * @see restore()
     * @see restoreList()
     */
    public function __construct(
        public readonly Value\Room $room,
        public readonly array $upcards,
        public readonly bool $reversed,
    )
    {

    }
}
