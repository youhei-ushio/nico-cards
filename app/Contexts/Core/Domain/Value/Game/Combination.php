<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Game;

use App\Contexts\Core\Domain\Exception\InvalidCombinationException;
use Dotenv\Parser\Value;

/**
 * カードの組み合わせ
 */
final class Combination
{
    /** @var int 階段の最小枚数 */
    private const MIN_SEQUENCE_COUNT = 3;

    /**
     * @param Card[] $cards
     */
    public function __construct(
        private readonly array $cards)
    {
        if (count($this->cards) === 0) {
            throw new InvalidCombinationException();
        }
    }

    /**
     * @param PlayCardRule $rule
     * @return void
     */
    public function validate(PlayCardRule $rule): void
    {
        if (count($this->cards) === 1) {
            return;
        }

        if ($this->isSameNumbers()) {
            return;
        }

        if ($this->isSequence()) {
            return;
        }

        throw new InvalidCombinationException();
    }

    /**
     * 同じ番号の組み合わせか
     *
     * @return bool
     */
    private function isSameNumbers(): bool
    {
        $firstCard = $this->cards[0];
        foreach ($this->cards as $card) {
            if (!$card->sameNumberAs($firstCard)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 階段の組み合わせか
     *
     * @return bool
     */
    private function isSequence(): bool
    {
        $numbers = array_map(
            function (Card $card) {
                return $card->number;
            }, $this->cards
        );
        if (count($numbers) < self::MIN_SEQUENCE_COUNT) {
            return false;
        }
        sort($numbers);
        return range($numbers[0], $numbers[count($numbers) - 1]) === $numbers;
    }
}
