<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Round\Play;

use App\Contexts\EventJournal\Domain\Entity\Game\Round;
use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;

final class Interactor
{
    public function __construct(
        private readonly RoundRepository $roundRepository,
    )
    {

    }

    public function execute(Journal $journal): void
    {
        $roundRecord = $this->roundRepository->restore($journal->roomId);
        $round = Round::restore($roundRecord);
        $round->play($journal->memberId, $journal->cards);
        $round->save($this->roundRepository);
    }
}
