<?php

namespace Database\Factories;

use App\Enums\EducationLevelEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::whereHas('role', fn ($query) => $query->where('name', RoleEnum::STUDENT))->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'level' => Arr::random([
                EducationLevelEnum::ELEMENTARY,
                EducationLevelEnum::JUNIOR_HIGH,
                EducationLevelEnum::SENIOR_HIGH,
                EducationLevelEnum::COLLEGE
            ]),
            'school_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'year_start' => now()->subYears(4)->format('Y-m-d'),
            'year_end' => now()->addYears(5)->format('Y-m-d'),
            'degree' => Arr::random(['BSED', 'BSIT',NULL]),
            'major' => Arr::random(['EDUCATION', 'IT', NULL]),
            'is_graduated' => rand(0, 1),
        ];
    }
}
