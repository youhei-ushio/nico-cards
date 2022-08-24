<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Entity;

use App\Contexts\Core\Domain\Value;

/**
 * 手札のディーラー
 */
final class Dealer
{
    /**
     * @param Player[] $players
     * @return Player[]
     */
    public function deal(array $players): array
    {
        $deck = Value\Game\Deck::create();
        $deck->shuffle();
        while ($deck->hasMoreCards()) {
            foreach ($players as $player) {
                if (!$deck->hasMoreCards()) {
                    break;
                }
                $card = $deck->deal();
                $player->deal($card);
            }
        }
        return $players;
    }
}
