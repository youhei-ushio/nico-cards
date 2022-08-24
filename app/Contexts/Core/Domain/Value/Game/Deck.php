<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Value;

/**
 * 1組のトランプ
 */
final class Deck
{
    /**
     * @param Value\Game\Card[] $cards
     */
    private function __construct(
        private array $cards,
    )
    {

    }

    /**
     * @return void
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * @return Value\Game\Card
     */
    public function deal(): Value\Game\Card
    {
        return array_shift($this->cards);
    }

    /**
     * @return bool
     */
    public function hasMoreCards(): bool
    {
        return count($this->cards) > 0;
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        $cards = array_merge(
            Value\Game\Card::spades(),
            Value\Game\Card::hearts(),
            Value\Game\Card::clubs(),
            Value\Game\Card::diamonds(),
            [
                Value\Game\Card::joker(),
            ],
        );
        return new self($cards);
    }
}
