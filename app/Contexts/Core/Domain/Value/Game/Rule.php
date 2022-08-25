<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

final class Rule
{
    /**
     * @param Card[] $upcards
     * @param Card[] $playCards
     */
    public function __construct(
        private readonly array $upcards,
        private readonly array $playCards,
    )
    {

    }

    /**
     * @return bool
     */
    public function playable(): bool
    {
        if (!empty($this->upcards) && count($this->upcards) !== count($this->playCards)) {
            return false;
        }
        if (!$this->maxCardIn($this->playCards)->greaterThan($this->maxCardIn($this->upcards))) {
            return false;
        }

        return true;
    }

    /**
     * @param Card[] $cards
     * @return Card
     */
    private function maxCardIn(array $cards): Card
    {
        $maxCard = $cards[0];
        foreach ($cards as $card) {
            if ($card->greaterThan($maxCard)) {
                $maxCard = $card;
            }
        }
        return $maxCard;
    }
}
