<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        User::truncate();
        Student::truncate();
        Employee::truncate();

        $roleData = [
            [
                'name' => RoleEnum::ADMIN,
                'display_name' => RoleEnum::ADMIN->getDisplayName(),
                'description' => (RoleEnum::ADMIN)->getDescription(),
            ],
            [
                'name' => RoleEnum::REGISTRAR,
                'display_name' => RoleEnum::REGISTRAR->getDisplayName(),
                'description' => (RoleEnum::REGISTRAR)->getDescription(),
            ],
            [
                'name' => RoleEnum::STUDENT,
                'display_name' => RoleEnum::STUDENT->getDisplayName(),
                'description' => (RoleEnum::STUDENT)->getDescription(),
            ],
        ];

        $roles = Role::factory(3)
            ->sequence(fn ($sequence) => $roleData[$sequence->index])
            ->create();

        $users = User::factory(3)
            ->sequence(fn ($sequence) => ['username' => $roles[$sequence->index]->name, 'role_id' => $roles[$sequence->index]->id])
            ->create();

        Student::factory()->create([
            'user_id' => $users->toQuery()->whereHas('role', fn ($query) => $query->where('name', RoleEnum::STUDENT))->first()->id,
            'is_approved' => true,
            'approved_by' => $users->toQuery()->whereHas('role', fn ($query) => $query->where('name', RoleEnum::ADMIN))->first()->id,
        ]);

        Employee::factory(2)
            ->sequence(function ($sequence) use ($users) {
                if ($sequence->index == 1) {
                    return [
                        'user_id' => $users->toQuery()->whereHas('role', fn ($query) => $query->where('name', RoleEnum::REGISTRAR))->first()->id,
                    ];
                }

                return [
                    'user_id' => $users->toQuery()->whereHas('role', fn ($query) => $query->where('name', RoleEnum::ADMIN))->first()->id,
                ];
            })->create();
    }
}
