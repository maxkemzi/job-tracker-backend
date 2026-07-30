<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string',
            'role' => 'required|string',
            'date_applied' => 'required|date',
            'salary_expectation' => 'nullable|integer',
            'notes' => 'nullable|string',
            'job_url' => 'nullable|string',
        ]);

        $application = Application::create([
            'user_id' => $request->user()->id,
            'company' => $validated['company'],
            'role' => $validated['role'],
            'date_applied' => $validated['date_applied'],
            'salary_expectation' => $validated['salary_expectation'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'job_url' => $validated['job_url'] ?? null,
        ]);

        return response()->json($application, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $this->authorize('view', $application);

        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'company' => 'sometimes|required|string',
            'role' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:applied,screening,interview,technical,offer,rejected',
            'date_applied' => 'sometimes|required|date',
            'salary_expectation' => 'nullable|integer',
            'notes' => 'nullable|string',
            'job_url' => 'nullable|string',
        ]);

        $application->update($validated);

        return response()->json($application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        $application->delete();

        return response()->json(null, 204);
    }
}
