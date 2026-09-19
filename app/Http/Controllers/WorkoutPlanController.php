<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkoutPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workoutPlans = Auth::user()->workoutPlans()->with('exercises')->get();
        return response()->json($workoutPlans, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',

                'exercises' => 'required|array|min:1',
                'exercises.*.exercise_id' => 'required|exists:exercises,id|distinct',
                'exercises.*.sets' => 'required|integer|min:1',
                'exercises.*.reps' => 'required|integer|min:1',
                'exercises.*.rest_seconds' => 'required|integer|min:0',
                'exercises.*.order' => 'required|integer|min:1',
            ]);

            DB::beginTransaction();

            // 1. Crear el workout plan
            $workoutPlan = WorkoutPlan::create([
                'user_id' => Auth::id(),
                'name' => $dataValidated['name'],
                'description' => $dataValidated['description'] ?? null,
            ]);

            // 2. Crear las relaciones en la tabla pivot
            foreach ($dataValidated['exercises'] as $exercise) {

                $workoutPlan->exercises()->attach(
                    $exercise['exercise_id'],
                    [
                        'sets' => $exercise['sets'],
                        'reps' => $exercise['reps'],
                        'rest_seconds' => $exercise['rest_seconds'],
                        'order' => $exercise['order'],
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'message' => 'Workout plan created successfully',
                'workout_plan' => $workoutPlan->load('exercises'),
            ], 201);
        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutPlan $workoutPlan)
    {
        if ($workoutPlan->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Workout plan not found',
            ], 404);
        }

        $workoutPlan->load('exercises');

        return response()->json([
            'workout_plan' => $workoutPlan,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutPlan $workoutPlan)
    {
        if ($workoutPlan->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Workout plan not found',
            ], 404);
        }

        $workoutPlan->delete();

        return response()->json([
            'message' => 'Workout plan deleted successfully',
        ], 200);
    }
}
