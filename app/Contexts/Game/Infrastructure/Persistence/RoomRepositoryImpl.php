<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Infrastructure\Persistence\RoomRecordCreatable;
use App\Contexts\Game\Domain\Exception\RoundNotFoundException;
use App\Contexts\Game\Domain\Persistence\RoomRepository;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;

final class RoomRepositoryImpl implements RoomRepository
{
    use RoomRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $id): RoomRestoreRecord
    {
        try {
            $row = Models\Room::query()
                ->with([
                    'users',
                    'users.profile',
                ])
                ->whereHas('users')
                ->where('id', function (Builder $builder) use ($id) {
                    $builder->select('room_id')
                        ->distinct()
                        ->from('room_users')
                        ->where('user_id', $id->getValue());
                })
                ->firstOrFail()
                ->toArray();
            return $this->createRoomRecord($row);
        } catch (ModelNotFoundException) {
            throw new RoundNotFoundException();
        }
    }
}
