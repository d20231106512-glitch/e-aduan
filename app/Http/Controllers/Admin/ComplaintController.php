<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get the selected category filter value from the request
        $selectedCategory = $request->get('category');

        // 2. Build the query instance
        $query = DB::table('complaints');

        // 3. If a specific category is chosen, apply a filtering condition
        if (!empty($selectedCategory)) {
            $query->where('category', $selectedCategory);
        }

        // 4. Fetch the final filtered data list ordered by the latest dates
        $complaints = $query->orderBy('created_at', 'desc')->get();

        // 5. Extract a unique list of all existing categories in your database to populate the dropdown automatically
        $allCategories = DB::table('complaints')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('admin.complaints.index', compact('complaints', 'allCategories', 'selectedCategory'));
    }
    public function show($id)
    {
        $complaint = DB::table('complaints')->where('id', $id)->first();

        if (!$complaint) {
            return redirect()->route('admin.complaints.index')->with('error', 'Complaint not found.');
        }

        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        // ADJUST THIS SIDE BASED ON WHAT YOUR SUPABASE QUERY IN STEP 1 REVEALED:
        // If your database uses capital letters, match them exactly here!
        $finalStatus = $request->status;
        if ($finalStatus === 'submitted') {
            $finalStatus = 'Submitted';
        }
        if ($finalStatus === 'in_progress') {
            $finalStatus = 'Investigating';
        }
        if ($finalStatus === 'resolved') {
            $finalStatus = 'Resolved';
        }

        try {
            DB::table('complaints')
                ->whereRaw("id = ?::uuid", [$id])
                ->update([
                    'status' => $finalStatus, // Sends the perfect casing
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Complaint tracking status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Database Exception: ' . $e->getMessage());
        }
    }
}
