<?php

declare(strict_types=1);

namespace App\Contexts\Core\Domain\Value;

use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;
use App\Contexts\Core\Domain\Persistence\RoomListRepository;
use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use Generator;
use IteratorIterator;
use Traversable;

/**
 * 部屋
 */
final class Room
{
    /**
     * newによるインスタンス化はさせない
     *
     * @param Room\Id $id
     * @param Room\Name $name
     * @param Member[] $members
     * @param bool $isFull
     * @see restore()
     * @see restoreList()
     */
    private function __construct(
        public readonly Room\Id $id,
        public readonly Room\Name $name,
        public readonly array $members,
        public readonly bool $isFull,
    )
    {

    }

    /**
     * @param Member $member
     * @return bool
     */
    public function exists(Member $member): bool
    {
        foreach ($this->members as $enteredMember) {
            if ($enteredMember->id->equals($member->id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 永続化されたエンティティを復元する
     *
     * @param RoomRestoreRecord $record
     * @return self
     */
    public static function restore(RoomRestoreRecord $record): self
    {
        return self::restoreFromRecord($record);
    }

    /**
     * 永続化されたエンティティのリストを復元する
     *
     * @param RoomListRepository $repository
     * @return RoomCollection
     */
    public static function restoreList(RoomListRepository $repository): RoomCollection
    {
        return new class(self::constructGenerator($repository)) extends IteratorIterator implements RoomCollection
        {
            public function __construct(readonly Traversable $iterator)
            {
                parent::__construct($this->iterator);
            }

            function current(): Room
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
     * @param RoomListRepository $repository
     * @return Generator
     */
    private static function constructGenerator(RoomListRepository $repository): Generator
    {
        foreach ($repository as $record) {
            yield self::restoreFromRecord($record);
        }
    }

    /**
     * @param RoomRestoreRecord $record
     * @return static
     */
    private static function restoreFromRecord(RoomRestoreRecord $record): self
    {
        $members = array_map(function (MemberRestoreRecord $memberRecord) {
            return Member::restore($memberRecord);
        }, $record->members);

        $limit = 4;

        return new self(
            id: $record->id,
            name: $record->name,
            members: $members,
            isFull: count($members) >= $limit,
        );
    }
}
