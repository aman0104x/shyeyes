<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reported_id' => 'required|exists:users,id',
            'reason'      => 'required|string|max:255',
            'details'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $report = Report::create([
            'reporter_id' => auth()->id(), // token se reporter
            'reported_id' => $request->reported_id,
            'reason'      => $request->reason,
            'details'     => $request->details,
        ]);

        return response()->json([
            'message' => 'Report created successfully',
            'report'  => $report->load(['reporterUser', 'reportedUser'])
        ], 201);
    }
}
