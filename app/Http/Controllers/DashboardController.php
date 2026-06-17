<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'Pending')->count(),
            'investigation' => Complaint::where('status', 'Under Investigation')->count(),
            'resolved' => Complaint::where('status', 'Resolved')->count()
        ]);
    }
}
