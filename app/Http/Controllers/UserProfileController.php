<?php

namespace App\Http\Controllers;

use App\Models\userProfile;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userProfile = Auth::user()->userProfile;
        return response()->json($userProfile, 200);
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
                'age' => 'required|integer|min:0',
                'height' => 'required|numeric|min:0',
                'weight' => 'required|numeric|min:0',
                'gender' => 'required|string|in:male,female,other',
                'bio' => ['nullable', 'string'],
                'avatar' => ['nullable', 'string'],
                'label' => ['nullable', 'string'],
            ]);

            $user = Auth::user();

            if ($user->userProfile()->exists()) {
                return response()->json([
                    'message' => 'User profile already exists',
                ], 409);
            }

            DB::beginTransaction();
            $userProfile = $user->userProfile()->create($dataValidated);
            DB::commit();

            return response()->json([
                'message' => 'User profile created successfully',
                'userProfile' => $userProfile,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(userProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(userProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, userProfile $userProfile)
    {
        if ($userProfile->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $data = $request->validate([
            'age' => ['required', 'integer', 'min:0'],
            'height' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'gender' => ['required', 'string', 'in:male,female,other'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
            'label' => ['nullable', 'string'],
        ]);

        $userProfile->update($data);

        return response()->json([
            'message' => 'User profile updated successfully',
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userProfile $userProfile)
    {
        if ($userProfile->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $userProfile->delete();

        return response()->json([
            'message' => 'User profile deleted successfully',
        ], 200);
    }
}
