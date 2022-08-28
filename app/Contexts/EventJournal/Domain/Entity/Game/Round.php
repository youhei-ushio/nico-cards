<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity\Game;

use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Exception\CannotDestroyRoundException;
use App\Contexts\EventJournal\Domain\Exception\CannotPassException;
use App\Contexts\EventJournal\Domain\Exception\NotEnoughPlayerException;
use App\Contexts\EventJournal\Domain\Exception\TooManyPlayersException;
use App\Contexts\EventJournal\Domain\Exception\TurnPlayerNotFoundException;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundSaveRecord;

final class Round
{
    /** @var int 最小人数 */
    private const MIN_PLAYERS = 3;

    /** @var int 最大人数 */
    private const MAX_PLAYERS = 5;

    /**
     * @param Value\Game\Round\Id|null $id ラウンドID
     * @param Value\Room\Id $roomId 部屋ID
     * @param Upcard|null $upcard 場札
     * @param Value\Game\Round\Turn $turn ターン
     * @param bool $reversed 革命による反転中かどうか
     * @param Player[] $players 全てのプレイヤー
     * @param Value\Game\PlayCardRule $rule ルール
     */
    private function __construct(
        private readonly Value\Game\Round\Id|null $id,
        private readonly Value\Room\Id $roomId,
        private Upcard|null $upcard,
        private Value\Game\Round\Turn $turn,
        private readonly bool $reversed,
        private array $players,
        private readonly Value\Game\PlayCardRule $rule,
        private bool $finished,
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
        array_walk($this->players, function (Player $player) use ($playerId, $cards) {
            if (!$player->id->equals($playerId)) {
                return;
            }
            $player->deal($cards);
        });
    }

    /**
     * ラウンド開始（最初のターン設定）
     *
     * @return void
     */
    public function start(): void
    {
        array_walk($this->players, function (Player $player) {
            $player->start();
        });
    }

    /**
     * カードを場に出す
     *
     * @param Value\Member\Id $playerId
     * @param Value\Game\Card[] $cards
     * @return Upcard
     */
    public function play(Value\Member\Id $playerId, array $cards): Upcard
    {
        $combination = new Value\Game\Combination($cards);
        $combination->validate($this->rule);

        array_walk($this->players, function (Player $player) use ($playerId, $cards) {
            if (!$player->id->equals($playerId)) {
                return;
            }
            foreach ($cards as $card) {
                $player->play($card);
            }
            if ($player->finished()) {
                $player->setRank($this->getNextRank());
            }
        });

        if ($this->upcard === null) {
            $this->upcard = Upcard::create($playerId, $cards);
        } else {
            $this->upcard->validate($cards, $this->rule);
            $this->upcard->play($playerId, $cards);
        }

        if ($this->countPlayers() <= 1) {
            $this->setLowestRank();
            $this->finished = true;
        }

        $this->turn = $this->turn->next();
        $this->setNextTurnPlayer();
        return $this->upcard;
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
            finished: $this->finished,
            players: array_map(
                function (Player $player) {
                    return $player->createSaveRecord();
                }, $this->players),
            upcard: $this->upcard?->createSaveRecord(),
        ));
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * @param RoundRepository $repository
     * @return void
     */
    public function destroy(RoundRepository $repository): void
    {
        if (!$this->finished) {
            throw new CannotDestroyRoundException();
        }
        $repository->destroy($this->id);
    }

    /**
     * @param Value\Room $room
     * @param array $players
     * @return self
     */
    public static function create(Value\Room $room, array $players): self
    {
        if (count($players) < self::MIN_PLAYERS) {
            throw new NotEnoughPlayerException();
        }
        if (count($players) > self::MAX_PLAYERS) {
            throw new TooManyPlayersException();
        }

        return new self(
            id: null,
            roomId: $room->id,
            upcard: null,
            turn: Value\Game\Round\Turn::first(),
            reversed: false,
            players: $players,
            rule: new Value\Game\PlayCardRule(false),
            finished: false,
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
            rule: new Value\Game\PlayCardRule($record->reversed),
            finished: $record->finished,
        );
    }

    /**
     * 次ターンのプレイヤーを設定する
     *
     * @return void
     */
    private function setNextTurnPlayer(): void
    {
        $currentTurnIndex = -1;
        foreach ($this->players as $index => $player) {
            if ($player->onTurn) {
                $currentTurnIndex = $index;
               break;
            }
        }
        if ($currentTurnIndex < 0) {
            throw new TurnPlayerNotFoundException();
        }

        $nextTurnIndex = $this->getNextTurnPlayerIndex($currentTurnIndex);
        $finishedCount = 0;
        while (true) {
            // 場札が次ターンのプレイヤーが出したものなら場札を流す
            if ($this->upcard?->playerId?->equals($this->players[$nextTurnIndex]->id)) {
                $this->upcard = null;
            }
            if ($this->players[$nextTurnIndex]->finished()) {
                $nextTurnIndex = $this->getNextTurnPlayerIndex($nextTurnIndex);
                $finishedCount++;
                if ($finishedCount >= count($this->players)) {
                    throw new TurnPlayerNotFoundException();
                }
                continue;
            }
            $this->players[$nextTurnIndex]->onTurn = true;
            $this->players[$currentTurnIndex]->onTurn = false;
            return;
        }
    }

    /**
     * 次ターンのプレイヤーの要素indexを取得する
     *
     * @param int $currentTurnIndex
     * @return int
     * @note 順番はプレイヤーの入室順に回す
     */
    private function getNextTurnPlayerIndex(int $currentTurnIndex): int
    {
        if (isset($this->players[$currentTurnIndex + 1])) {
            return $currentTurnIndex + 1;
        } else {
            return 0;
        }
    }

    /**
     * @return Value\Game\Round\Rank
     */
    private function getNextRank(): Value\Game\Round\Rank
    {
        $finishedCount = 0;
        foreach ($this->players as $player) {
            if ($player->finished()) {
                $finishedCount++;
            }
        }
        return Value\Game\Round\Rank::fromNumber($finishedCount);
    }

    /**
     * @return int
     */
    private function countPlayers(): int
    {
        $count = 0;
        foreach ($this->players as $player) {
            if ($player->finished()) {
                continue;
            }
            $count++;
        }
        return $count;
    }

    /**
     * 最下位の設定
     *
     * @return void
     */
    private function setLowestRank(): void
    {
        $rank = count($this->players);
        array_walk($this->players, function (Player $player) use ($rank) {
            if ($player->finished()) {
                return;
            }
            $player->setRank(Value\Game\Round\Rank::fromNumber($rank));
        });
    }
}
