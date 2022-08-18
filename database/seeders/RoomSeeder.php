<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

/**
 * 部屋の初期データ
 *
 * @noinspection PhpUnused
 */
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Room::factory()
            ->count(3)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['name' => '大富豪' . ($sequence->index + 1)],
            ))
            ->create();
    }
}
