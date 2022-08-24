<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Infrastructure\Persistence\RoomRecordCreatable;
use App\Contexts\EventJournal\Domain\Exception\MemberNotFoundException;
use App\Contexts\EventJournal\Domain\Persistence\RoomRepository;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class RoomRepositoryImpl implements RoomRepository
{
    use RoomRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Room\Id $id): RoomRestoreRecord
    {
        try {
            $row = Models\Room::query()
                ->with([
                    'users',
                ])
                ->findOrFail($id->getValue())
                ->toArray();
            return $this->createRoomRecord($row);
        } catch (ModelNotFoundException) {
            throw new MemberNotFoundException();
        }
    }
}
