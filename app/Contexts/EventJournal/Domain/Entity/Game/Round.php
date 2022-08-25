<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Persistence\CardSaveRecord;
use App\Contexts\Core\Domain\Persistence\PlayerSaveRecord;
use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use App\Contexts\EventJournal\Domain\Exception\TurnPlayerNotFoundException;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\UpcardSaveRecord;

final class Round
{
    /**
     * @param Value\Game\Round\Id|null $id ラウンドID
     * @param Value\Room\Id $roomId 部屋ID
     * @param Value\Game\Card[] $upcards 場札
     * @param Value\Game\Round\Turn $turn ターン
     * @param bool $reversed 革命による反転中かどうか
     * @param Player[] $players 全てのプレイヤー
     */
    private function __construct(
        private readonly Value\Game\Round\Id|null $id,
        private readonly Value\Room\Id $roomId,
        private array $upcards,
        private Value\Game\Round\Turn $turn,
        private bool $reversed,
        private array $players,
    )
    {

    }

    /**
     * 手札を配る
     *
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @return void
     */
    public function deal(Value\Member\Id $playerId, array $cards): void
    {
        foreach ($this->players as $index => $player) {
            if (!$player->id->equals($playerId)) {
                continue;
            }
            $this->players[$index]->deal($cards);
        }
    }

    /**
     * ラウンド開始（最初のターン設定）
     *
     * @return void
     */
    public function start(): void
    {
        foreach ($this->players as $player) {
            $player->start();
        }
    }

    /**
     * カードを場に出す
     *
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @return void
     */
    public function play(Value\Member\Id $playerId, array $cards): void
    {
        $playCards = [];
        foreach ($this->players as $player) {
            if (!$player->id->equals($playerId)) {
                continue;
            }
            foreach ($cards as $card) {
                $playCards[] = $player->play($card->suit, $card->number);
            }
        }

        $rule = new Value\Game\Rule($this->upcards, $playCards);
        if (!$rule->playable()) {
            throw new CannotPlayCardException();
        }

        $this->upcards = $playCards;
        $this->turn = $this->turn->next();
        $this->setNextTurnPlayer();
    }

    /**
     * パスする
     *
     * @param Value\Member\Id $playerId
     * @return void
     */
    public function pass(Value\Member\Id $playerId): void
    {
        $this->turn = $this->turn->next();
        $this->setNextTurnPlayer();
    }

    /**
     * @param RoundRepository $repository
     * @return void
     */
    public function save(RoundRepository $repository): void
    {
        $repository->save(new RoundSaveRecord(
            $this->id?->getValue(),
            $this->roomId->getValue(),
            turn: $this->turn->getValue(),
            reversed: $this->reversed,
            finished: false,
            players: array_map(
                function (Player $player) {
                    return new PlayerSaveRecord(
                        $player->id->getValue(),
                        array_map(
                            function (Value\Game\Card $card) {
                                return new CardSaveRecord(
                                    $card->suit,
                                    $card->number,
                                );
                            }, $player->hand),
                        $player->onTurn,
                    );
                }, $this->players),
            upcards: array_map(
                function (Value\Game\Card $card) {
                    return new UpcardSaveRecord(
                        $this->id->getValue(),
                        $card->suit,
                        $card->number,
                    );
                }, $this->upcards),
        ));
    }

    /**
     * @param Value\Room $room
     * @param array $players
     * @return self
     */
    public static function create(Value\Room $room, array $players): self
    {
        return new self(
            id: null,
            roomId: $room->id,
            upcards: [],
            turn: Value\Game\Round\Turn::first(),
            reversed: false,
            players: $players,
        );
    }

    /**
     * @param RoundRestoreRecord $record
     * @return static
     */
    public static function restore(RoundRestoreRecord $record): self
    {
        return new self(
            id: Value\Game\Round\Id::fromNumber($record->id),
            roomId: Value\Room\Id::fromNumber($record->roomId),
            upcards: array_map(
                function (CardRestoreRecord $cardRecord) {
                    return Value\Game\Card::restore($cardRecord);
                },
                $record->upcards),
            turn: Value\Game\Round\Turn::fromNumber($record->turn),
            reversed: $record->reversed,
            players: Player::restoreList($record->playerRecords),
        );
    }

    /**
     * 次ターンのプレイヤーを設定する
     *
     * @return void
     */
    private function setNextTurnPlayer(): void
    {
        foreach ($this->players as $index => $player) {
            if (!$player->onTurn) {
                continue;
            }
            $this->players[$index]->onTurn = false;
            if (isset($this->players[$index + 1])) {
                $this->players[$index + 1]->onTurn = true;
            } else {
                $this->players[0]->onTurn = true;
            }
            return;
        }
        throw new TurnPlayerNotFoundException();
    }
}
