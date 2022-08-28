<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Create;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Player;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Exception\NotEnoughPlayerException;
use App\Contexts\EventJournal\Domain\Exception\TooManyPlayersException;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly RoomRepository $roomRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        if ($roundRecord !== null) {
            $round = Round::restore($roundRecord);
            if ($round->isFinished()) {
                $round->destroy($this->roundRepository);
            } else {
                // すでに対戦中の場合は何もしない
                return;
            }
        }

        $room = Value\Room::restore($this->roomRepository->restore($journal->roomId));
        $players = Player::createList($room->members);
        try {
            $round = Round::create($room, $players);
            $round->save($this->roundRepository);
        } catch (NotEnoughPlayerException) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                $journal->roomId->getValue(),
                __('game.round.not_enough_player'),
                Value\Event\Message\Level::error()->getValue(),
            ));
        } catch (TooManyPlayersException) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                $journal->roomId->getValue(),
                __('game.round.too_many_players'),
                Value\Event\Message\Level::error()->getValue(),
            ));
        }
    }
}
