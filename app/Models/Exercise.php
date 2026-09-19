<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{

    protected function casts(): array
    {
        return [
            'secondary_muscles' => 'array',
            'is_stretch' => 'boolean',
        ];
    }

    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'workout_exercises', 'exercise_id', 'workout_plan_id')
            ->withPivot('sets', 'reps', 'rest_seconds', 'order')
            ->withTimestamps();
    }
}
