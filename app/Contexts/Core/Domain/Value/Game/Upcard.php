<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\UpcardRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class Upcard implements IteratorAggregate
{
    /**
     * @param Value\Game\Card[] $cards
     * @see restore()
     */
    private function __construct(
        public readonly array $cards,
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
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->cards);
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
            array_map(
                function (CardRestoreRecord $cardRecord) {
                    return Value\Game\Card::restore($cardRecord);
                }, $record->cards
            ),
        );
    }
}
