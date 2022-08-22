<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Persistence;

use App\Contexts\Lobby\Domain\Exception\MemberNotFoundException;
use App\Contexts\Core\Domain\Persistence\MemberRepository;
use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class MemberRepositoryImpl implements MemberRepository
{
    use MemberRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $id): MemberRestoreRecord
    {
        try {
            $row = Models\User::query()
                ->with([
                    'profile',
                    'rooms',
                ])
                ->findOrFail($id->getValue())
                ->toArray();
            return $this->createMemberRecord($row);
        } catch (ModelNotFoundException) {
            throw new MemberNotFoundException();
        }
    }
}
