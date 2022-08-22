<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoomRestoreRecord;
use App\Contexts\Game\Domain\Persistence\PlayerRepository;
use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Game\Domain\Exception\PlayerNotFoundException;
use App\Contexts\Core\Domain\Value;
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
    public function restore(Value\Member\Id $memberId): RoomRestoreRecord
    {
        try {
            $row = Models\Room::query()
                ->with([
                    'users',
                ])
                ->whereExists(function (Builder $builder) use ($memberId) {
                    $builder->selectRaw(1)
                        ->from('room_users')
                        ->where('user_id', $memberId->getValue())
                        ->whereRaw('room_id = rooms.id');
                })
                ->firstOrFail()
                ->toArray();
            return $this->createRoomRecord($row);
        } catch (ModelNotFoundException) {
            throw new PlayerNotFoundException();
        }
    }
}
