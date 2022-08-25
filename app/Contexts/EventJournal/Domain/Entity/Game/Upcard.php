<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\CardSaveRecord;
use App\Contexts\Core\Domain\Persistence\UpcardRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use App\Contexts\EventJournal\Domain\Persistence\UpcardSaveRecord;

final class Upcard
{
    /**
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @see restore()
     */
    private function __construct(
        public Value\Member\Id $playerId,
        private array $cards,
    )
    {

    }

    /**
     * @param Value\Game\Card[] $cards
     * @param Value\Game\Rule $rule
     * @return void
     */
    public function validate(array $cards, Value\Game\Rule $rule): void
    {
        if (!$rule->playable($this->cards, $cards)) {
            throw new CannotPlayCardException();
        }
    }

    /**
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @return void
     */
    public function play(Value\Member\Id $playerId, array $cards): void
    {
        $this->playerId = $playerId;
        $this->cards = $cards;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return implode(',', array_map(
            function (Value\Game\Card $card) {
                return $card->toString();
            }, $this->cards)
        );
    }

    /**
     * @return UpcardSaveRecord
     */
    public function createSaveRecord(): UpcardSaveRecord
    {
        return new UpcardSaveRecord(
            $this->playerId->getValue(),
            array_map(
                function (Value\Game\Card $card) {
                    return new CardSaveRecord(
                        $card->suit,
                        $card->number,
                    );
                }, $this->cards),
        );
    }

    /**
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @return self
     */
    public static function create(
        Value\Member\Id $playerId,
        array $cards,
    ): self
    {
        return new self(
            $playerId,
            $cards,
        );
    }

    /**
     * @param UpcardRestoreRecord|null $record
     * @return self|null
     */
    public static function restore(UpcardRestoreRecord|null $record): self|null
    {
        if ($record === null) {
            return null;
        }
        return new self(
            Value\Member\Id::fromNumber($record->playerId),
            array_map(
                function (CardRestoreRecord $cardRecord) {
                    return Value\Game\Card::restore($cardRecord);
                }, $record->cards
            ),
        );
    }
}
