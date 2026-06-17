<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Count total complaints from the active table
            $totalComplaints = DB::table('complaints')->count();
        } catch (\Exception $e) {
            $totalComplaints = 0;
        }

        try {
            // Check for emergency keywords inside the description text safely
            $emergencyComplaints = DB::table('complaints')
                ->whereRaw("description ILIKE '%kecurian%' 
                            OR description ILIKE '%theft%' 
                            OR description ILIKE '%harassment%' 
                            OR description ILIKE '%accident%' 
                            OR description ILIKE '%pencerobohan%'")
                ->count();
        } catch (\Exception $e) {
            $emergencyComplaints = 0;
        }

        try {
            // Grab latest 5 records matching real columns
            $latestComplaints = DB::table('complaints')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $latestComplaints = [];
        }

        return view('admin.settings.dashboard', compact('totalComplaints', 'emergencyComplaints', 'latestComplaints'));
    }
}
