<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $contacts = DB::table('security_contacts')->orderBy('name', 'asc')->get();
            $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            $contacts = collect([]);
            $users = collect([]);
            session()->now('error', 'Amaran Paparan Tetapan: ' . $e->getMessage());
        }

        return view('admin.settings.index', compact('contacts', 'users'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'zone' => 'nullable|string|max:255',
        ]);

        try {
            DB::table('security_contacts')->insert([
                'name' => $request->name,
                'phone_number' => $request->phone,
                'zone_assignment' => $request->zone,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('admin.settings.index')->with('success', 'Kenalan kecemasan berjaya disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan kenalan: ' . $e->getMessage());
        }
    }

    // 🟢 KAEDAH BAHARU: MENGEMASKINI KENALAN KECEMASAN EXISTING
    public function updateContact(Request $request, $id)
    {
        // 1. Sahkan input yang dihantar daripada borang edit
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'zone' => 'nullable|string|max:255',
        ]);

        try {
            // 2. Kemaskan kini data dalam database mengikut ID kenalan
            DB::table('security_contacts')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'phone_number' => $request->phone,
                    'zone_assignment' => $request->zone,
                    'updated_at' => now()
                ]);

            return redirect()->route('admin.settings.index')->with('success', 'Kenalan kecemasan berjaya dikemas kini!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengemas kini kenalan: ' . $e->getMessage());
        }
    }

    public function destroyContact($id)
    {
        try {
            DB::table('security_contacts')->where('id', $id)->delete();
            return redirect()->route('admin.settings.index')->with('success', 'Kenalan berjaya dipadam.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ralat Pemadaman: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Rekod pengguna tidak ditemui.');
            }

            DB::table('users')->where('id', $id)->delete();

            return redirect()->route('admin.settings.index')->with('success', 'Akaun pengguna telah dipadamkan sepenuhnya daripada sistem.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tidak dapat memadam pengguna: ' . $e->getMessage());
        }
    }
}
