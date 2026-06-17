<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch saved hotlines
        $contacts = DB::table('security_contacts')->get();

        // Fetch real app users from Supabase Profiles table instead of standard Laravel table
        $users = DB::table('profiles')
            ->whereIn('role', ['student', 'staff'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.settings.index', compact('contacts', 'users'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'zone_assignment' => 'nullable|string|max:255'
        ]);

        DB::table('security_contacts')->insert([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'zone_assignment' => $request->zone_assignment,
        ]);

        return redirect()->back()->with('success', 'Security contact added successfully.');
    }

    public function destroyContact($id)
    {
        DB::table('security_contacts')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Security contact removed.');
    }

    public function deleteUser($id)
    {
        // Deletes out of your profiles database table safely
        DB::table('profiles')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'User reference removed successfully.');
    }
}
