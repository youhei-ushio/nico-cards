<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Domain\Persistence\JournalRestoreRecord;
use Generator;
use IteratorIterator;
use Traversable;

final class Journal
{
    public function __construct(
        public readonly Value\Event\Id $id,
        public readonly Value\Event\Type $type,
        public readonly Value\Room\Id|null $roomId,
        public readonly Value\Member\Id|null $memberId,
        public readonly Value\Game\Card|null $card,
    )
    {

    }

    /**
     * 永続化されたエンティティのリストを復元する
     *
     * @param JournalListRepository $repository
     * @return JournalCollection
     */
    public static function restoreList(JournalListRepository $repository): JournalCollection
    {
        return new class(self::constructGenerator($repository)) extends IteratorIterator implements JournalCollection
        {
            public function __construct(readonly Traversable $iterator)
            {
                parent::__construct($this->iterator);
            }

            function current(): Journal
            {
                return parent::current();
            }

            function key(): int
            {
                return parent::key();
            }
        };
    }

    /**
     * @param JournalListRepository $repository
     * @return Generator
     */
    private static function constructGenerator(JournalListRepository $repository): Generator
    {
        foreach ($repository as $record) {
            yield self::restoreFromRecord($record);
        }
    }

    /**
     * @param JournalRestoreRecord $record
     * @return static
     */
    private static function restoreFromRecord(JournalRestoreRecord $record): self
    {
        return new self(
            id: $record->id,
            type: $record->type,
            roomId: $record->roomId,
            memberId: $record->memberId,
            card: $record->card,
        );
    }
}
