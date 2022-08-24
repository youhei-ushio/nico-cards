<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayTurnException;
use App\Contexts\EventJournal\Domain\Exception\CardNotFoundException;

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
        public bool $onTurn,
    )
    {

    }

    /**
     * 手札を配る
     *
     * @param Value\Game\Card[] $cards
     * @return void
     */
    public function deal(array $cards): void
    {
        $this->hand = $cards;
    }

    /**
     * ラウンド開始（最初のターン設定）
     *
     * @return void
     */
    public function start(): void
    {
        if ($this->hasStartCard()) {
            $this->onTurn = true;
        }
    }

    /**
     * カードを場に出す
     *
     * @param string $suit
     * @param int $number
     * @return Value\Game\Card
     */
    public function play(string $suit, int $number): Value\Game\Card
    {
        if (!$this->onTurn) {
            throw new CannotPlayTurnException();
        }
        foreach ($this->hand as $index => $card) {
            if ($card->suit === $suit && $card->number === $number) {
                unset($this->hand[$index]);
                return $card;
            }
        }
        throw new CardNotFoundException();
    }

    /**
     * 最初の順番を決めるカードを持っているかどうか
     *
     * @return bool
     */
    private function hasStartCard(): bool
    {
        foreach ($this->hand as $card) {
            if ($card->isStartCard()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param PlayerRestoreRecord $record
     * @return self
     */
    public static function restore(PlayerRestoreRecord $record): self
    {
        return new self(
            id: Value\Member\Id::fromNumber($record->id),
            hand: array_map(
                function (CardRestoreRecord $cardRecord) {
                    return Value\Game\Card::restore($cardRecord);
                }, $record->hand),
            onTurn: $record->onTurn,
        );
    }

    /**
     * @param PlayerRestoreRecord[] $records
     * @return self[]
     */
    public static function restoreList(array $records): array
    {
        return array_map(function (PlayerRestoreRecord $record) {
            return self::restore($record);
        }, $records);
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
