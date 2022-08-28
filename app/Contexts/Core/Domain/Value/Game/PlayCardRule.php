<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Value;

/**
 * 場にカードを出す際のルール
 */
final class PlayCardRule
{
    /**
     * @param bool $reversed
     */
    public function __construct(
        private readonly bool $reversed,
    )
    {

    }

    /**
     * @param Value\Game\Card[] $upcards
     * @param Value\Game\Card[] $playCards
     * @return bool
     */
    public function playable(array $upcards, array $playCards): bool
    {
        if (!empty($upcards) && count($upcards) !== count($playCards)) {
            return false;
        }

        $strong = $this->strongCardIn($playCards)->strongerThan($this->strongCardIn($upcards));
        if ($this->reversed) {
            $strong = !$strong;
        }
        return $strong;
    }

    /**
     * @param Card[] $cards
     * @return Card
     */
    private function strongCardIn(array $cards): Card
    {
        $maxCard = $cards[0];
        foreach ($cards as $card) {
            if ($card->strongerThan($maxCard)) {
                $maxCard = $card;
            }
        }
        return $maxCard;
    }
}
