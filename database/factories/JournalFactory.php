<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Journal;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class JournalFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Journal::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'type' => 'enter',
            'suit' => null,
            'number' => null,
        ];
    }
}
