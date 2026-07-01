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
            // Kira jumlah keseluruhan aduan daripada jadual aktif
            $totalComplaints = DB::table('complaints')->count();
        } catch (\Exception $e) {
            $totalComplaints = 0;
        }

        try {
            // Semak kata kunci kecemasan di dalam teks deskripsi secara selamat
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
            // TETAP: Pilih lajur skema struktur baharu anda secara eksplisit (category_id, title)
            $latestComplaints = DB::table('complaints')
                ->select('id', 'title', 'category_id', 'location', 'status', 'created_at', 'description')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // TETAP: Sandaran ditukar kepada objek koleksi kosong untuk mengelakkan ralat kitaran template break
            $latestComplaints = collect([]);
        }

        return view('admin.settings.dashboard', compact('totalComplaints', 'emergencyComplaints', 'latestComplaints'));
    }
}
