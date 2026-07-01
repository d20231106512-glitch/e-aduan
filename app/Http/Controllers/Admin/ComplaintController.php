<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->get('category');
        $filter = $request->get('filter');
        // 🔍 Ambil kata kunci carian daripada input text
        $search = $request->get('search');

        $query = DB::table('complaints')
            ->select('id', 'title', 'category_id', 'location', 'status', 'created_at', 'description', 'status_remarks');

        // 1. Tapis mengikut kata kunci carian (tajuk aduan) jika diisi
        if (!empty($search)) {
            $query->where('title', 'ILIKE', '%' . $search . '%');
        }

        if ($filter === 'kecemasan') {
            $query->where(function ($q) {
                $q->where('description', 'ILIKE', '%kecurian%')
                    ->orWhere('description', 'ILIKE', '%theft%')
                    ->orWhere('description', 'ILIKE', '%harassment%')
                    ->orWhere('description', 'ILIKE', '%accident%')
                    ->orWhere('description', 'ILIKE', '%pencerobohan%');
            });
        }

        // 2. Tapis mengikut kategori yang dipilih dari dropdown
        if (!empty($selectedCategory)) {
            $query->where('category_id', $selectedCategory);
        }

        $complaints = $query->orderBy('created_at', 'desc')->get();

        foreach ($complaints as $complaint) {
            if (strtolower(trim($complaint->status ?? '')) === 'pending') {
                $complaint->status = 'Submitted';
            }
        }

        $allCategories = DB::table('complaints')
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id');

        // Hantar pembolehubah $search sekali ke view supaya teks carian tidak hilang selepas ditekan
        return view('admin.complaints.index', compact('complaints', 'allCategories', 'selectedCategory', 'search'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.complaints.index')->with('error', 'Format ID Aduan tidak sah.');
        }

        $complaint = DB::table('complaints')->where('id', $id)->first();

        if (!$complaint) {
            return redirect()->route('admin.complaints.index')->with('error', 'Rekod aduan tidak ditemui.');
        }

        if (strtolower(trim($complaint->status ?? '')) === 'pending') {
            $complaint->status = 'Submitted';
        }

        $officers = DB::table('security_contacts')->orderBy('name', 'asc')->get();

        return view('admin.complaints.show', compact('complaint', 'officers'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'assigned_to' => 'nullable|string',
            'status_remarks' => 'required|string|min:5'
        ], [
            'status_remarks.required' => 'Sila masukkan penerangan tindakan atau sebab perubahan status kes ini.'
        ]);

        if (!is_numeric($id)) {
            return redirect()->back()->with('error', 'Format rujukan ID tidak sah.');
        }

        $input = strtolower(trim($request->status));

        if ($input === 'investigating' || $input === 'in_progress' || $input === 'in progress') {
            $finalStatus = 'In Progress';
        } elseif ($input === 'resolved') {
            $finalStatus = 'Resolved';
        } elseif ($input === 'rejected') {
            $finalStatus = 'Rejected';
        } else {
            $finalStatus = 'Submitted';
        }

        try {
            DB::table('complaints')
                ->where('id', $id)
                ->update([
                    'status' => $finalStatus,
                    'assigned_to' => $request->assigned_to,
                    'status_remarks' => $request->status_remarks,
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Status aduan, tugasan pengendali dan nota tindakan berjaya dikemas kini!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat Pangkalan Data: ' . $e->getMessage());
        }
    }
}
