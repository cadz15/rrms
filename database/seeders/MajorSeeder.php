<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $primary = EducationLevel::where('name', 'Primary Level')->first();
        $secondary = EducationLevel::where('name', 'Secondary Level')->first();
        $tertiary = EducationLevel::where('name', 'Tertiary Level')->first();

        $primaryMajor = [
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6'
        ];

        $secondaryMajor = [
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10',
            'Grade 11',
            'Grade 12',
            'Junior High',
            'Senior High'
        ];

        $tertiaryMajor = [
            'Bachelor of Science in Business Administation',
            'Bachelor of Elementary Education',
            'Bachelor of Science in Hospitality Management'
        ];

        Major::factory(count($primaryMajor))
            ->sequence(fn ($sequence) => ['name' => $primaryMajor[$sequence->index], 'education_level_id' => $primary->id])
            ->create();

        Major::factory(count($secondaryMajor))
            ->sequence(fn ($sequence) => ['name' => $secondaryMajor[$sequence->index], 'education_level_id' => $secondary->id])
            ->create();

        Major::factory(count($tertiaryMajor))
            ->sequence(fn ($sequence) => ['name' => $tertiaryMajor[$sequence->index], 'education_level_id' => $tertiary->id])
            ->create();
    }
}
