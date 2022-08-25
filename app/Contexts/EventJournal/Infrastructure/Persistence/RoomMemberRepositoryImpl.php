<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Value;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberRestoreRecord;
use App\Contexts\EventJournal\Domain\Persistence\RoomMemberSaveRecord;
use App\Contexts\EventJournal\Domain\Exception\MemberNotFoundException;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

final class RoomMemberRepositoryImpl implements RoomMemberRepository
{
    use RoomMemberRecordCreatable;

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $id): RoomMemberRestoreRecord
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

    /**
     * @inheritDoc
     */
    public function save(RoomMemberSaveRecord $record): void
    {
        DB::transaction(function () use ($record) {
            Models\RoomUser::query()
                ->where('user_id', $record->memberId)
                ->delete();

            if ($record->roomId === null) {
                return;
            }

            $row = new Models\RoomUser();
            $row->fill([
                'user_id' => $record->memberId,
                'room_id' => $record->roomId,
            ]);
            $row->saveOrFail();
        });
    }
}
