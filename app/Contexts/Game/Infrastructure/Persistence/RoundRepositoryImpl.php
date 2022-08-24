<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Infrastructure\Persistence\RoundRecordCreatable;
use App\Contexts\Game\Domain\Persistence\RoundRepository;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;

final class RoundRepositoryImpl implements RoundRepository
{
    use RoundRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $memberId): RoundRestoreRecord|null
    {
        try {
            $row = Models\Round::query()
                ->with([
                    'users',
                    'users.profile',
                    'users.user',
                    'users.hand',
                    'users',
                    'upcards',
                ])
                ->whereHas('room')
                ->whereHas('users')
                ->where('room_id', function (Builder $builder) use ($memberId) {
                    $builder->select('room_id')
                        ->distinct()
                        ->from('room_users')
                        ->where('user_id', $memberId->getValue());
                })
                ->firstOrFail()
                ->toArray();
            $row['member_id'] = $memberId->getValue();
            return $this->createRoundRecord($row);
        } catch (ModelNotFoundException) {
            return null;
        }
    }
}
