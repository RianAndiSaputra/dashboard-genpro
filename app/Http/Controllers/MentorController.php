<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentor;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    public function index()
    {
        try {
            $mentors = Mentor::with('user')->get();
            return response()->json(['data' => $mentors], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $mentor = Mentor::create([
                'user_id' => $request->user_id,
            ]);

            return response()->json(['message' => 'Mentor created successfully', 'data' => $mentor], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $mentor = Mentor::with('user')->findOrFail($id);
            return response()->json(['data' => $mentor], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Mentor not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $mentor = Mentor::findOrFail($id);
            $mentor->update(['user_id' => $request->user_id]);

            return response()->json(['message' => 'Mentor updated successfully', 'data' => $mentor], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update mentor'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $mentor = Mentor::findOrFail($id);
            $mentor->delete();

            return response()->json(['message' => 'Mentor deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete mentor'], 500);
        }
    }
}
