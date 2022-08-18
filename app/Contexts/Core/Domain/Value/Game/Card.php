<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class Card
{
    /** @var string */
    private const SUIT_SPADE = 'Spade';

    /** @var string */
    private const SUIT_HEART = 'Heart';

    /** @var string */
    private const SUIT_CLUB = 'Club';

    /** @var string */
    private const SUIT_DIAMOND = 'Diamond';

    /** @var string */
    private const JOKER = 'Joker';

    /** @var int */
    private const MIN_NUMBER = 1;

    /** @var int */
    private const MAX_NUMBER = 13;

    /** @var string[] */
    protected const SUITS = [
        self::SUIT_SPADE,
        self::SUIT_HEART,
        self::SUIT_CLUB,
        self::SUIT_DIAMOND,
        self::JOKER,
    ];

    public function __construct(
        public readonly string $suit,
        public readonly int $number,
    )
    {
        if (in_array($this->suit, self::SUITS)) {
            throw new InvalidValueException($suit, self::class);
        }
        if ($this->number < self::MIN_NUMBER || $this->number > self::MAX_NUMBER) {
            throw new InvalidValueException($suit, self::class);
        }
    }

    /**
     * @return bool
     */
    public function isJoker(): bool
    {
        return $this->suit === self::JOKER;
    }
}
