<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $json = file_get_contents(database_path('data/exercises.json'));

        $exercises = json_decode($json, true);

        foreach ($exercises as $exercise) {
            Exercise::create([
                'name' => $exercise['name'],
                'slug' => $exercise['slug'],
                'equipment' => $exercise['equipment'],
                'exercise_type' => $exercise['exerciseType'],
                'primary_muscle' => $exercise['primaryMuscle'],
                'secondary_muscles' => $exercise['secondaryMuscles'],
                'is_stretch' => $exercise['isStretch'],
            ]);
        }
    }
}
