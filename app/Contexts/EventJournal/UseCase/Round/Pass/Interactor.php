<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Pass;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Exception\CannotPlayCardException;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageRepository;
use App\Contexts\EventJournal\Domain\Persistence\EventMessageSaveRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
        private readonly EventMessageRepository $eventMessageRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->memberId);
        $round = Round::restore($roundRecord);
        try {
            $round->play($journal->memberId, $journal->cards);
        } catch (CannotPlayCardException) {
            $this->eventMessageRepository->save(new EventMessageSaveRecord(
                $journal->id->getValue(),
                $journal->memberId->getValue(),
                __('game.round.cannot_play_card'),
                Value\Event\Message\Level::error()->getValue(),
            ));
            return;
        }
        $round->save($this->roundRepository);
    }
}
