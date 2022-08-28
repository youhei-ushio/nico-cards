<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Replay;

use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Exception\UnknownEventException;
use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Domain\Persistence\SnapshotRepository;
use App\Contexts\EventJournal\Domain\Persistence\SnapshotSaveRecord;
use App\Contexts\EventJournal\UseCase\Room\Enter\Interactor as RoomEnterInteractor;
use App\Contexts\EventJournal\UseCase\Room\Leave\Interactor as RoomLeaveInteractor;
use App\Contexts\EventJournal\UseCase\Round\Create\Interactor as RoundCreateInteractor;
use App\Contexts\EventJournal\UseCase\Round\Deal\Interactor as RoundDealInteractor;
use App\Contexts\EventJournal\UseCase\Round\Start\Interactor as RoundStartInteractor;
use App\Contexts\EventJournal\UseCase\Round\Play\Interactor as RoundPlayInteractor;
use App\Contexts\EventJournal\UseCase\Round\Pass\Interactor as RoundPassInteractor;
use Illuminate\Support\Facades\Log;
use Throwable;

final class Interactor
{
    public function __construct(
        private readonly JournalListRepository $journalListRepository,
        private readonly SnapshotRepository $snapshotRepository,
        private readonly RoomEnterInteractor $roomEnter,
        private readonly RoomLeaveInteractor $roomLeave,
        private readonly RoundCreateInteractor $roundCreate,
        private readonly RoundDealInteractor $roundDeal,
        private readonly RoundStartInteractor $roundStart,
        private readonly RoundPlayInteractor $roundPlay,
        private readonly RoundPassInteractor $roundPass,
    )
    {

    }

    public function execute(Input $input): void
    {
        $retry = 0;
        while (true) {
            $this->journalListRepository->restore($input->roomId);
            if ($this->journalListRepository->empty()) {
                $retry++;
                if ($retry >= 1000) {
                    return;
                }
                sleep(1);
                continue;
            }

            $journals = Journal::restoreList($this->journalListRepository);
            $lastId = null;
            foreach ($journals as $journal) {
                try {
                    if ($journal->type->equals('enter')) {
                        $this->roomEnter->execute($journal);
                    } elseif ($journal->type->equals('leave')) {
                        $this->roomLeave->execute($journal);
                    } elseif ($journal->type->equals('round')) {
                        $this->roundCreate->execute($journal);
                    } elseif ($journal->type->equals('deal')) {
                        $this->roundDeal->execute($journal);
                    } elseif ($journal->type->equals('start')) {
                        $this->roundStart->execute($journal);
                    } elseif ($journal->type->equals('play')) {
                        $this->roundPlay->execute($journal);
                    } elseif ($journal->type->equals('pass')) {
                        $this->roundPass->execute($journal);
                    } else {
                        throw new UnknownEventException();
                    }
                } catch (Throwable $exception) {
                    Log::error($exception->getMessage(), ['file' => "{$exception->getFile()}:{$exception->getLine()}", 'journal_id' => $journal->id->getValue()]);
                }
                $lastId = $journal->id;
            }

            $this->snapshotRepository->save(
                new SnapshotSaveRecord(
                    $lastId->getValue(),
                    $input->roomId->getValue(),
                )
            );
        }
    }
}
