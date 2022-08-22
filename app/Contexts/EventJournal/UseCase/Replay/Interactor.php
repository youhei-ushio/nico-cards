<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\UseCase\Replay;

use App\Contexts\EventJournal\Domain\Entity\Journal;
use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Domain\Persistence\SnapshotRepository;
use App\Contexts\EventJournal\Domain\Persistence\SnapshotSaveRecord;
use App\Contexts\EventJournal\UseCase\Room\Enter\Interactor as RoomEnterInteractor;
use App\Contexts\EventJournal\UseCase\Room\Leave\Interactor as RoomLeaveInteractor;
use Illuminate\Support\Facades\Log;
use Throwable;

final class Interactor
{
    public function __construct(
        private readonly JournalListRepository $journalListRepository,
        private readonly SnapshotRepository $snapshotRepository,
        private readonly RoomEnterInteractor $roomEnter,
        private readonly RoomLeaveInteractor $roomLeave,
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
                if ($retry >= 10) {
                    return;
                }
                sleep(2);
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
                    }
                } catch (Throwable $exception) {
                    Log::error($exception->getMessage(), ['file' => "{$exception->getFile()}:{$exception->getLine()}", 'journal_id' => $journal->id->getValue()]);
                }
                $lastId = $journal->id;
            }

            $this->snapshotRepository->save(
                new SnapshotSaveRecord(
                    $lastId,
                    $input->roomId,
                )
            );
        }
    }
}
