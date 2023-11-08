<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Degree::truncate();

        $degrees = [
            'Bachelor of Elementary Education',
            'Bachelor of Industrial Technology',
            'Bachelor of Technology and Livelihood Education',
            'Bachelor of Science in Civil Engineering',
            'Bachelor of Science in Computer Engineering',
            'Bachelor of Science in Criminology',
            'Bachelor of Science in Electrical Engineering',
            'Bachelor of Science in Mechanical Engineering',
            'Bachelor of Science in Food Technology',
            'Bachelor of Science in Hospitality Management',
            'Bachelor of Science in Tourism Management',
            'Bachelor of Science in Information Technology'
        ];

        Degree::factory(count($degrees))->sequence(fn ($sequence) => ['name' => $degrees[$sequence->index]])->create();
    }
}
