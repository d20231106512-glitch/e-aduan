<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Tetapkan bulan dan tahun semasa jika tiada yang dipilih
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear = $request->get('year', date('Y'));

        try {
            // 1. Dapatkan jumlah keseluruhan laporan bagi bulan yang dipilih secara selamat
            $totalComplaints = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->count();

            // 2. TETAP: Menambah '%baru%' ke dalam tatasusunan kueri untuk mengemas kini pengiraan nilai kad analitis anda
            $pendingCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->where(function ($query) {
                    $query->where(DB::raw('LOWER(status)'), 'like', '%pending%')
                        ->orWhere(DB::raw('LOWER(status)'), 'like', '%submitted%')
                        ->orWhere(DB::raw('LOWER(status)'), 'like', '%acknowledged%')
                        ->orWhere(DB::raw('LOWER(status)'), 'like', '%baru%');
                })
                ->count();

            $investigatingCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->where(function ($query) {
                    $query->where(DB::raw('LOWER(status)'), 'like', '%investigating%')
                        ->orWhere(DB::raw('LOWER(status)'), 'like', '%in_progress%')
                        ->orWhere(DB::raw('LOWER(status)'), 'like', '%in progress%');
                })
                ->count();

            $resolvedCount = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->where(DB::raw('LOWER(status)'), 'like', '%resolved%')
                ->count();

            // 3. Kumpulkan rekod untuk visualisasi jadual helaian senarai
            $monthlyRecords = DB::table('complaints')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->orderBy('created_at', 'asc')
                ->get();
        } catch (\Exception $e) {
            // Definisi sandaran jika berlaku sebarang kegagalan atau sambungan pangkalan data terputus
            $totalComplaints = 0;
            $pendingCount = 0;
            $investigatingCount = 0;
            $resolvedCount = 0;
            $monthlyRecords = collect([]);
        }

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
