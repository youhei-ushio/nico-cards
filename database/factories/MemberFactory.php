<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MemberFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Member::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
