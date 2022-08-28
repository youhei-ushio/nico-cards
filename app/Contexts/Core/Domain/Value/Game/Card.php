<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use JsonSerializable;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

/**
 * カード
 */
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
    private const SUITS = [
        self::SUIT_SPADES,
        self::SUIT_HEARTS,
        self::SUIT_CLUBS,
        self::SUIT_DIAMONDS,
        self::JOKER,
    ];

    private const STRENGTHS = [
        3 => 1,
        4 => 2,
        5 => 3,
        6 => 4,
        7 => 5,
        8 => 6,
        9 => 7,
        10 => 8,
        11 => 9,
        12 => 10,
        13 => 11,
        1 => 12,
        2 => 13,
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
     * 同一のカードかどうか
     *
     * @param Card $card
     * @return bool
     */
    public function equals(self $card): bool
    {
        return $this->suit === $card->suit && $this->number === $card->number;
    }

    /**
     * シンボルが同じかどうか
     *
     * @param Card $card
     * @return bool
     */
    public function sameSuitAs(self $card): bool
    {
        return $this->suit === $card->suit;
    }

    /**
     * 番号が同じかどうか
     *
     * @param Card $card
     * @return bool
     */
    public function sameNumberAs(self $card): bool
    {
        return $this->number === $card->number;
    }

    /**
     * より強いかどうか
     *
     * @param Card $card
     * @return bool
     */
    public function strongerThan(self $card): bool
    {
        if (self::isJoker() && $card->isJoker()) {
            return false;
        }
        if (self::isJoker() && !$card->isJoker()) {
            return true;
        }
        if (!self::isJoker() && $card->isJoker()) {
            return false;
        }
        return self::STRENGTHS[$this->number] > self::STRENGTHS[$card->number];
    }

    /**
     * より弱いかどうか
     *
     * @param Card $card
     * @return bool
     */
    public function weakerThan(self $card): bool
    {
        if (self::isJoker() && $card->isJoker()) {
            return false;
        }
        if (!self::isJoker() && $card->isJoker()) {
            return true;
        }
        if (self::isJoker() && !$card->isJoker()) {
            return false;
        }
        return self::STRENGTHS[$this->number] < self::STRENGTHS[$card->number];
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

    /**
     * @return string
     */
    public function toString(): string
    {
        $shortName = '';
        if ($this->isJoker()) {
            return '<span class="joker">&#x1f0cf;</span>';
        }
        switch ($this->suit) {
            case self::SUIT_SPADES:
                $shortName = '<span class="spades">&#x2660;</span>';
                break;
            case self::SUIT_HEARTS:
                $shortName = '<span class="hearts">&#x2665;</span>';
                break;
            case self::SUIT_DIAMONDS:
                $shortName = '<span class="diamonds">&#x2666;</span>';
                break;
            case self::SUIT_CLUBS:
                $shortName = '<span class="clubs">&#x2663;</span>';
                break;
        }
        if ($this->number === 1) {
            $shortName .= 'A';
        } elseif ($this->number === 11) {
            $shortName .= 'J';
        } elseif ($this->number === 12) {
            $shortName .= 'Q';
        } elseif ($this->number === 13) {
            $shortName .= 'K';
        } else {
            $shortName .= $this->number;
        }
        return $shortName;
    }
}
