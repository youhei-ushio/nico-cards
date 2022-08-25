<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Domain\Entity;

use App\Contexts\Core\Domain\Persistence\CardRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\JournalListRepository;
use App\Contexts\EventJournal\Domain\Persistence\JournalRestoreRecord;
use Generator;
use IteratorIterator;
use Traversable;

final class Journal
{
    /**
     * @param Value\Event\Id $id
     * @param Value\Event\Type $type
     * @param Value\Room\Id|null $roomId
     * @param Value\Member\Id|null $memberId
     * @param Value\Game\Card[] $cards
     */
    public function __construct(
        public readonly Value\Event\Id $id,
        public readonly Value\Event\Type $type,
        public readonly Value\Room\Id|null $roomId,
        public readonly Value\Member\Id|null $memberId,
        public readonly Value\Member\Name|null $memberName,
        public readonly array $cards,
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
     * @return self
     */
    private static function restoreFromRecord(JournalRestoreRecord $record): self
    {
        return new self(
            id: Value\Event\Id::fromNumber($record->id),
            type: Value\Event\Type::fromString($record->type),
            roomId: Value\Room\Id::fromNumber($record->roomId),
            memberId: Value\Member\Id::fromNumber($record->memberId),
            memberName: Value\Member\Name::fromString($record->memberName),
            cards: array_map(
                function (CardRestoreRecord $cardRecord) {
                    return Value\Game\Card::restore($cardRecord);
                }, $record->cards),
        );
    }
}
