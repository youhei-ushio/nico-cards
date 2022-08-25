<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\CardSaveRecord;
use App\Contexts\Core\Domain\Persistence\PlayerSaveRecord;
use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotPassException;
use App\Contexts\EventJournal\Domain\Exception\TurnPlayerNotFoundException;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundSaveRecord;

final class Round
{
    /**
     * @param Value\Game\Round\Id|null $id ラウンドID
     * @param Value\Room\Id $roomId 部屋ID
     * @param Upcard|null $upcard 場札
     * @param Value\Game\Round\Turn $turn ターン
     * @param bool $reversed 革命による反転中かどうか
     * @param Player[] $players 全てのプレイヤー
     */
    private function __construct(
        private readonly Value\Game\Round\Id|null $id,
        private readonly Value\Room\Id $roomId,
        private Upcard|null $upcard,
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

        if ($this->upcard === null) {
            $this->upcard = Upcard::create($playerId, $playCards);
        } else {
            $this->upcard->validate($playCards, new Value\Game\Rule($this->reversed));
            $this->upcard->play($playerId, $playCards);
        }
        $this->turn = $this->turn->next();
        $this->setNextTurnPlayer();
    }

    /**
     * パスする
     *
     * @return void
     */
    public function pass(): void
    {
        if ($this->upcard === null) {
            throw new CannotPassException();
        }
        $this->turn = $this->turn->next();
        $nextPlayer = $this->setNextTurnPlayer();

        // 場札が次ターンのプレイヤーが出したものなら場札を流す
        if ($this->upcard->playerId->equals($nextPlayer->id)) {
            $this->upcard = null;
        }
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
            upcard: $this->upcard?->createSaveRecord(),
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
            upcard: null,
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
            upcard: Upcard::restore($record->upcard),
            turn: Value\Game\Round\Turn::fromNumber($record->turn),
            reversed: $record->reversed,
            players: Player::restoreList($record->playerRecords),
        );
    }

    /**
     * 次ターンのプレイヤーを設定する
     *
     * @return Player 設定された次ターンのプレイヤー
     */
    private function setNextTurnPlayer(): Player
    {
        foreach ($this->players as $index => $player) {
            if (!$player->onTurn) {
                continue;
            }
            $this->players[$index]->onTurn = false;
            if (isset($this->players[$index + 1])) {
                $this->players[$index + 1]->onTurn = true;
                return $this->players[$index + 1];
            } else {
                $this->players[0]->onTurn = true;
                return $this->players[0];
            }
        }
        throw new TurnPlayerNotFoundException();
    }
}
