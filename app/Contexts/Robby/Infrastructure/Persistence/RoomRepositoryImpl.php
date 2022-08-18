<?php

declare(strict_types=1);

namespace App\Contexts\Robby\Infrastructure\Persistence;

use App\Contexts\Robby\Domain\Exception\MemberNotFoundException;
use App\Core\Domain\Persistence\RoomRepository;
use App\Core\Domain\Persistence\RoomRestoreRecord;
use App\Core\Domain\Value;
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
