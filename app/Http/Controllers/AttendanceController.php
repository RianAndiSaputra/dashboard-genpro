<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // Get all attendances
    public function index()
    {
        $attendances = Attendance::with('mentee')->get();
        return response()->json($attendances);
    }

    // Create new attendance
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentee_id' => 'required|exists:mentee_profiles,id',
            'check_in_time' => 'required|date',
            'selfie_url' => 'sometimes|url|max:255'
        ]);

        $attendance = Attendance::create($validated);
        return response()->json($attendance, 201);
    }

    // Get single attendance
    public function show($id)
    {
        $attendance = Attendance::with('mentee')->findOrFail($id);
        return response()->json($attendance);
    }

    // Update attendance
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'mentee_id' => 'sometimes|exists:mentee_profiles,id',
            'check_in_time' => 'sometimes|date',
            'selfie_url' => 'sometimes|url|max:255'
        ]);

        $attendance->update($validated);
        return response()->json($attendance);
    }

    // Delete attendance
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return response()->json(['message' => 'Attendance record deleted successfully']);
    }
}
