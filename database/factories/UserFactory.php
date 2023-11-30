<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'id_number' => fake()->name(),
            'password' => bcrypt('1234'),
            'role_id' => Role::factory(),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'sex' => $gender == 1 ? GenderEnum::MALE : GenderEnum::FEMALE,
            'contact_number' => '09178781045',
            'birth_date' => $this->faker->date('Y-m-d'),
            'birth_place' => $this->faker->address,
            'address' => $this->faker->address,
        ];
    }

    public function admin()
    {
        return $this->state([
            'id_number' => 'admin',
            'role_id' => Role::admin()->first()->id
        ]);
    }

    public function registrar()
    {
        return $this->state([
            'id_number' => 'registrar',
            'role_id' => Role::registrar()->first()->id
        ]);
    }

    public function student()
    {
        return $this->state([
            'id_number' => rand(1000000, 9999999) . '-' . rand(1, 2),
            'role_id' => Role::student()->first()->id
        ]);
    }

    public function approved()
    {
        return $this->state([
            'is_approved' => true,
            'approved_by' => User::inRandomOrder()->whereHas('role', fn ($query) => $query->admin())->first()?->id
        ]);
    }
}
