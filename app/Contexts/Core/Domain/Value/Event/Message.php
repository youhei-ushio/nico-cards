<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value\Event;

use App\Contexts\Core\Domain\Persistence\EventMessageListRepository;
use App\Contexts\Core\Domain\Persistence\EventMessageRestoreRecord;
use App\Contexts\Core\Domain\Value;
use ArrayIterator;
use IteratorIterator;

final class Message
{
    public function __construct(
        public readonly Value\Event\Id $id,
        public readonly Value\Event\OccurredDateTime $occurredAt,
        public readonly Value\Event\Message\Body $body,
        public readonly Value\Event\Message\Level $level,
    )
    {

    }

    /**
     * 永続化されたエンティティのリストを復元する
     *
     * @param EventMessageListRepository $repository
     * @return MessageCollection
     */
    public static function restoreList(EventMessageListRepository $repository): MessageCollection
    {
        return new class(self::restoreFromRecords($repository)) extends IteratorIterator implements MessageCollection
        {
            private readonly int $total;

            public function __construct(array $entities)
            {
                $this->total = count($entities);
                parent::__construct(new ArrayIterator($entities));
            }

            function current(): Message
            {
                return parent::current();
            }

            function key(): int
            {
                return parent::key();
            }

            public function total(): int
            {
                return $this->total;
            }

            public function empty(): bool
            {
                return $this->total === 0;
            }
        };
    }

    /**
     * @param EventMessageListRepository $repository
     * @return self[]
     */
    private static function restoreFromRecords(EventMessageListRepository $repository): array
    {
        $records = [];
        foreach ($repository as $record) {
            $records[] = self::restoreFromRecord($record);
        }
        return $records;
    }

    /**
     * @param EventMessageRestoreRecord $record
     * @return static
     */
    private static function restoreFromRecord(EventMessageRestoreRecord $record): self
    {
        return new self(
            id: $record->id,
            occurredAt: $record->occurredAt,
            body: $record->body,
            level: $record->level,
        );
    }
}
