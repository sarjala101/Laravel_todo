<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcademicQualificationController extends Controller
{
    /**
     * Get all academic qualifications of the authenticated user.
     */
    public function index(Request $request)
    {
        $qualifications = $request->user()
            ->academicQualifications()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Academic qualifications retrieved successfully',
            'data' => $qualifications,
        ], 200);
    }

    /**
     * Store a new academic qualification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $qualification = $request->user()->academicQualifications()->create([
            'degree' => $request->degree,
            'institution' => $request->institution,
            'field' => $request->field,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json([
            'message' => 'Academic qualification added successfully',
            'data' => $qualification,
        ], 201);
    }

    /**
     * Update an existing academic qualification.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $qualification = $request->user()
            ->academicQualifications()
            ->findOrFail($id);

        $qualification->update([
            'degree' => $request->degree,
            'institution' => $request->institution,
            'field' => $request->field,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json([
            'message' => 'Academic qualification updated successfully',
            'data' => $qualification,
        ], 200);
    }

    /**
     * Delete an academic qualification.
     */
    public function destroy(Request $request, $id)
    {
        $qualification = $request->user()
            ->academicQualifications()
            ->findOrFail($id);

        $qualification->delete();

        return response()->json([
            'message' => 'Academic qualification deleted successfully',
        ], 200);
    }
}
