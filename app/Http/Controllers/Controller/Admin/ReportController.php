<?php

namespace App\Http\Controllers\Controller\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Admin ke liye report list with proper relationships
        $reports = Report::with(['reporter', 'reported'])->latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        $report->load(['reporter', 'reported']);
        return view('admin.reports.index', compact('report'));
    }

    /**
     * Get report details for modal display
     */
    public function getReportDetails(Report $report)
    {
        $report->load(['reporter', 'reported']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $report->id,
                'reason' => $report->reason,
                'details' => $report->details,
                'created_at' => $report->created_at->format('M d, Y \a\t h:i A'),
                'created_at_full' => $report->created_at->format('F j, Y g:i A'),
                'reporter' => [
                    'id' => $report->reporter->id,
                    'name' => $report->reporter->full_name,
                    'email' => $report->reporter->email,
                    'image' => $report->reporter->img ?? 'https://via.placeholder.com/60x60'
                ],
                'reported' => [
                    'id' => $report->reported->id,
                    'name' => $report->reported->full_name,
                    'email' => $report->reported->email,
                    'image' => $report->reported->img ?? 'https://via.placeholder.com/60x60'
                ]
            ]
        ]);
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Report deleted successfully'
                ]);
            }

            return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting report: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error deleting report: ' . $e->getMessage());
        }
    }
}
