<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = rand(1, 2);

        return [
            'user_id' => User::inRandomOrder()
                ->whereHas('role', fn ($query) => $query->where('name', RoleEnum::ADMIN))->first()->id,
            'employee_number' => rand(1111111, 9999999)."-$gender",
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'sex' => $gender == 1 ? GenderEnum::MALE : GenderEnum::FEMALE,
            'contact_number' => '09178781045',
        ];
    }
}
