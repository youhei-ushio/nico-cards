<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Persistence;

use App\Contexts\Core\Infrastructure\Persistence\MemberRecordCreatable;
use App\Contexts\MyPage\Domain\Exception\MemberNotFoundException;
use App\Contexts\MyPage\Domain\Persistence\MemberRepository;
use App\Contexts\Core\Domain\Persistence\MemberRestoreRecord;
use App\Contexts\MyPage\Domain\Persistence\MemberSaveRecord;
use App\Contexts\Core\Domain\Value;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * データベースへの永続化の実装
 */
final class MemberRepositoryImpl implements MemberRepository
{
    use MemberRecordCreatable;

    /**
     * @inheritDoc
     */
    public function save(MemberSaveRecord $record): void
    {
        DB::transaction(function () use ($record) {
            $row = Models\Profile::query()
                ->where('user_id', $record->id->getValue())
                ->firstOrNew();
            $row->fill([
                'user_id' => $record->id->getValue(),
                'name' => $record->name->getValue(),
            ]);
            $row->saveOrFail();
        });
    }

    /**
     * @inheritDoc
     */
    public function restore(Value\Member\Id $id): MemberRestoreRecord
    {
        try {
            $row = Models\User::query()
                ->with([
                    'profile',
                ])
                ->findOrFail($id->getValue())
                ->toArray();
            return $this->createMemberRecord($row);
        } catch (ModelNotFoundException) {
            throw new MemberNotFoundException();
        }
    }
}
