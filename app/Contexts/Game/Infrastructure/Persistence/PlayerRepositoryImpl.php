<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Game\Domain\Persistence\PlayerRepository;
use App\Contexts\Game\Domain\Persistence\PlayerRestoreRecord;
use App\Contexts\Game\Domain\Exception\PlayerNotFoundException;
use App\Contexts\Core\Domain\Value;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class PlayerRepositoryImpl implements PlayerRepository
{
    use PlayerRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $id): PlayerRestoreRecord
    {
        try {
            $row = Models\User::query()
                ->with([
                    'profile',
                    'rooms',
                    'rooms.users',
                ])
                ->whereHas('rooms')
                ->findOrFail($id->getValue())
                ->toArray();
            return $this->createPlayerRecord($row);
        } catch (ModelNotFoundException) {
            throw new PlayerNotFoundException();
        }
    }
}
