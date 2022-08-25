<?php

declare(strict_types=1);

namespace App\Contexts\EventJournal\Infrastructure\Persistence;

use App\Contexts\Core\Domain\Persistence\RoundRestoreRecord;
use App\Contexts\Core\Domain\Value;
use App\Contexts\Core\Infrastructure\Persistence\RoundRecordCreatable;
use App\Contexts\EventJournal\Domain\Persistence\RoundRepository;
use App\Contexts\EventJournal\Domain\Persistence\RoundSaveRecord;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    /**
     * @inheritDoc
     * @throws Throwable
     * @noinspection PhpUndefinedFieldInspection
     */
    public function save(RoundSaveRecord $record): void
    {
        DB::transaction(function () use ($record) {
            if ($record->id === null) {
                $roundRow = new Models\Round();
            } else {
                $roundRow = Models\Round::query()->findOrFail($record->id);
            }
            $roundRow->fill([
                'room_id' => $record->roomId,
                'turn' => $record->turn,
                'reversed' => $record->reversed,
            ])
            ->saveOrFail();

            Models\RoundUser::query()
                ->where('round_id', $roundRow->id)
                ->delete();
            Models\RoundUserHand::query()
                ->where('round_id', $roundRow->id)
                ->delete();

            foreach ($record->players as $player) {
                $userRow = new Models\RoundUser();
                $userRow->fill([
                    'round_id' => $roundRow->id,
                    'user_id' => $player->id,
                    'on_turn' => $player->onTurn,
                ])->saveOrFail();

                foreach ($player->hand as $card) {
                    (new Models\RoundUserHand())
                        ->fill([
                            'round_id' => $roundRow->id,
                            'round_user_id' => $userRow->id,
                            'suit' => $card->suit,
                            'number' => $card->number,
                        ])
                        ->saveOrFail();
                }
            }

            Models\RoundUpcards::query()
                ->where('round_id', $roundRow->id)
                ->delete();
            foreach ($record->upcards as $upcardRecord) {
                (new Models\RoundUpcards())
                    ->fill([
                        'round_id' => $roundRow->id,
                        'suit' => $upcardRecord->suit,
                        'number' => $upcardRecord->number,
                    ])
                    ->saveOrFail();
            }
        });
    }
}
