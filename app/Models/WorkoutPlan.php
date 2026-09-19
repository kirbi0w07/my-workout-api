<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'user_id'])]

class WorkoutPlan extends Model
{
    //

    protected $table = 'workout_plans';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises', 'workout_plan_id', 'exercise_id')
            ->withPivot('sets', 'reps', 'rest_seconds', 'order')
            ->withTimestamps();
    }

    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSession::class);
    }
}
