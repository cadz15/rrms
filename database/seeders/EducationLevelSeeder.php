<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'Primary Level'],
            ['name' => 'Secondary Level'],
            ['name' => 'Bachelor of Science in Information Technology']
        ];

        EducationLevel::insert($levels);
    }
}
