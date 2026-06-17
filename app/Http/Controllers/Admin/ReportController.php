<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to the current month and year if none selected
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear = $request->get('year', date('Y'));

        try {
            // 1. Get total count for the selected month safely
            $totalComplaints = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->count();

            // 2. Clear status metrics counting matching your true Supabase lowercased enum values
            $pendingCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->whereIn('status', ['submitted', 'acknowledged'])
                ->count();

            $investigatingCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->where('status', 'in_progress')
                ->count();

            $resolvedCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->where('status', 'resolved')
                ->count();

            // 3. Gather records for the list sheet table visualization
            $monthlyRecords = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->orderBy('created_at', 'asc')
                ->get();
        } catch (\Exception $e) {
            // Fallback definitions if anything fails or database connection drops out
            $totalComplaints = 0;
            $pendingCount = 0;
            $investigatingCount = 0;
            $resolvedCount = 0;
            $monthlyRecords = collect([]); // Returns empty list framework to stop template loops from crashing
        }

        // Line 49: Compiles safely because variables are guaranteed to exist
        return view('admin.reports.index', compact(
            'totalComplaints',
            'pendingCount',
            'investigatingCount',
            'resolvedCount',
            'monthlyRecords',
            'selectedMonth',
            'selectedYear'
        ));
    }
}
