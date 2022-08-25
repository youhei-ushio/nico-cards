<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Domain\Persistence\JournalRestoreRecord;
use App\Models;
use Illuminate\Database\Query\Builder;

final class JournalListRepositoryImpl implements JournalListRepository
{
    use JournalRecordCreatable;

    /** @var array */
    private array $rows = [];

    public function restore(Value\Room\Id $roomId): void
    {
        $this->rows = Models\Journal::query()
            ->with([
                'user',
                'user.profile',
            ])
            ->where('id', '>', function (Builder $builder) use ($roomId) {
                $builder->selectRaw('ifnull(max(journal_id), 0)')
                    ->from('snapshots')
                    ->where('room_id', $roomId->getValue());
            })
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    public function rewind(): void
    {
        reset($this->rows);
    }

    public function current(): JournalRestoreRecord
    {
        return $this->createJournalRecord(current($this->rows));
    }

    public function key(): int
    {
        return key($this->rows);
    }

    public function next(): void
    {
        next($this->rows);
    }

    public function valid(): bool
    {
        return current($this->rows) !== false;
    }

    public function empty(): bool
    {
        return empty($this->rows);
    }
}
