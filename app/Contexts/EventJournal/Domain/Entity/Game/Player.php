<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayTurnException;
use App\Contexts\EventJournal\Domain\Exception\CardNotFoundException;
use App\Contexts\EventJournal\Domain\Persistence\CardSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\PlayerSaveRecord;

final class Player
{
    /**
     * @param Value\Member\Id $id
     * @param Value\Game\Card[] $hand
     * @param bool $onTurn
     * @param Value\Game\Round\Rank $rank
     */
    public function __construct(
        public readonly Value\Member\Id $id,
        private array $hand,
        public bool $onTurn,
        private Value\Game\Round\Rank $rank,
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
     * @param Value\Game\Card $card
     * @return void
     */
    public function play(Value\Game\Card $card): void
    {
        if (!$this->onTurn) {
            throw new CannotPlayTurnException();
        }
        foreach ($this->hand as $index => $handCard) {
            if ($handCard->equals($card)) {
                unset($this->hand[$index]);
                return;
            }
        }
        throw new CardNotFoundException();
    }

    /**
     * @return bool
     */
    public function finished(): bool
    {
        return empty($this->hand);
    }

    /**
     * @param Value\Game\Round\Rank $rank
     * @return void
     */
    public function setRank(Value\Game\Round\Rank $rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return PlayerSaveRecord
     */
    public function createSaveRecord(): PlayerSaveRecord
    {
        return new PlayerSaveRecord(
            id: $this->id->getValue(),
            hand: array_map(
                function (Value\Game\Card $card) {
                    return new CardSaveRecord(
                        $card->suit,
                        $card->number,
                    );
                }, $this->hand),
            onTurn: $this->onTurn,
            rank: $this->rank->getValue(),
        );
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
            rank: Value\Game\Round\Rank::fromNumber($record->rank),
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
                rank: Value\Game\Round\Rank::empty(),
            );
        }, $members);
    }
}
