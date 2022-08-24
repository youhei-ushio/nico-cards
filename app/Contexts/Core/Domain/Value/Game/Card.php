<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use JsonSerializable;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class Card implements JsonSerializable
{
    /** @var string */
    private const SUIT_SPADES = 'Spades';

    /** @var string */
    private const SUIT_HEARTS = 'Hearts';

    /** @var string */
    private const SUIT_CLUBS = 'Clubs';

    /** @var string */
    private const SUIT_DIAMONDS = 'Diamonds';

    /** @var string */
    private const JOKER = 'Joker';

    /** @var int */
    private const MIN_NUMBER = 1;

    /** @var int */
    private const MAX_NUMBER = 13;

    /** @var int */
    private const JOKER_NUMBER = 100;

    /** @var string[] */
    protected const SUITS = [
        self::SUIT_SPADES,
        self::SUIT_HEARTS,
        self::SUIT_CLUBS,
        self::SUIT_DIAMONDS,
        self::JOKER,
    ];

    public function __construct(
        public readonly string $suit,
        public readonly int $number,
    )
    {
        if (!in_array($this->suit, self::SUITS)) {
            throw new InvalidValueException($suit, self::class);
        }
        if ($suit !== self::JOKER) {
            if ($this->number < self::MIN_NUMBER || $this->number > self::MAX_NUMBER) {
                throw new InvalidValueException($suit, self::class);
            }
        }
    }

    /**
     * @return bool
     */
    public function isJoker(): bool
    {
        return $this->suit === self::JOKER;
    }

    /**
     * 最初の順番を決めるカード
     *
     * @return bool
     */
    public function isStartCard(): bool
    {
        return $this->suit === self::SUIT_DIAMONDS && $this->number === 3;
    }

    /**
     * @return self[]
     */
    public static function spades(): array
    {
        return self::cards(self::SUIT_SPADES);
    }

    /**
     * @return self[]
     */
    public static function hearts(): array
    {
        return self::cards(self::SUIT_HEARTS);
    }

    /**
     * @return self[]
     */
    public static function clubs(): array
    {
        return self::cards(self::SUIT_CLUBS);
    }

    /**
     * @return self[]
     */
    public static function diamonds(): array
    {
        return self::cards(self::SUIT_DIAMONDS);
    }

    /**
     * @return self
     */
    public static function joker(): self
    {
        return new self(self::JOKER, self::JOKER_NUMBER);
    }

    /**
     * @param CardRestoreRecord $record
     * @return self
     */
    public static function restore(CardRestoreRecord $record): self
    {
        return new self(
            $record->suit,
            $record->number,
        );
    }

    /**
     * @param string $suit
     * @return self[]
     */
    private static function cards(string $suit): array
    {
        $cards = [];
        for ($number = self::MIN_NUMBER; $number <= self::MAX_NUMBER; $number++) {
            $cards[] = new self(
                suit: $suit,
                number: $number,
            );
        }
        return $cards;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'suit' => $this->suit,
            'number' => $this->number,
        ];
    }
}
