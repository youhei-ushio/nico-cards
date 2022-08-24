<?php

declare(strict_types=1);

namespace App\Contexts\Game\Domain\Entity;

use App\Contexts\Core\Domain\Value;

final class Player
{
    /**
     * @param Value\Member\Id $id
     * @param Value\Game\Card[] $hand
     * @param bool $onTurn
     */
    public function __construct(
        public readonly Value\Member\Id $id,
        public array $hand,
        public readonly bool $onTurn,
    )
    {

    }

    /**
     * 手札を配る
     *
     * @param Value\Game\Card $card
     * @return void
     */
    public function deal(Value\Game\Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * @param Value\Member[] $members
     * @return self[]
     */
    public static function createList(array $members): array
    {
        return array_map(function (Value\Member $member) {
            return new self(
                id: $member->id,
                hand: [],
                onTurn: false,
            );
        }, $members);
    }
}
