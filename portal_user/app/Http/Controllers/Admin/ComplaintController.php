<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Papar Halaman Senarai Laporan Admin (Milik Amira)
     */
    public function index()
    {
        $complaints = DB::table('complaints')->orderBy('created_at', 'desc')->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Papar Dashboard User (Hanya keluar aduan milik dia sendiri)
     */
    public function userIndex()
    {
        $myComplaints = DB::table('complaints')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('user', compact('myComplaints'));
    }

    /**
     * Proses Simpan Aduan Menggunakan Aliran Tersuai (Kalis Ralat Temporary File Windows)
     */
    public function store(Request $request)
    {
        // 1. Ambil data teks daripada borang
        $category = $request->input('category');
        $incident_date = $request->input('incident_date');
        $incident_time = $request->input('incident_time');
        $location = $request->input('location');
        $description = $request->input('description');
        $isEmergency = $request->has('is_emergency') ? true : false;
        
        $imagePath = null;

        // 2. Menguruskan fail gambar secara tersuai menggunakan $_FILES global Windows bypass
        if (isset($_FILES['evidence_image']) && $_FILES['evidence_image']['error'] == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['evidence_image']['tmp_name'];
            $originalName = $_FILES['evidence_image']['name'];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            
            // Sahkan hanya format gambar dibenarkan
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
                $filename = 'bukti_' . time() . '.' . $ext;
                $destination = public_path('uploads/evidence/' . $filename);

                // Pastikan folder destinasi wujud
                if (!file_exists(public_path('uploads/evidence'))) {
                    mkdir(public_path('uploads/evidence'), 0777, true);
                }

                // Pindahkan fail terus ke folder public
                if (move_uploaded_file($tmpName, $destination)) {
                    $imagePath = 'uploads/evidence/' . $filename;
                }
            }
        } 
        
        // Jika kaedah $_FILES biasa gagal, kita guna kaedah standard Laravel sebagai pelan sandaran
        if (!$imagePath && $request->hasFile('evidence_image')) {
            $file = $request->file('evidence_image');
            if ($file->isValid()) {
                $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/evidence'), $filename);
                $imagePath = 'uploads/evidence/' . $filename;
            }
        }

        // 3. Masukkan rekod ke database Supabase / SQLite
        DB::table('complaints')->insert([
            'user_id' => Auth::id(),
            'category' => $category,
            'incident_date' => $incident_date,
            'incident_time' => $incident_time,
            'location' => $location,
            'description' => $description,

            // Legacy single evidence
            'evidence_photo' => $imagePath,

            // Multiple evidence not handled in this legacy admin controller
            'evidence_photos' => null,

            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/user')->with('success', 'Aduan berserta imej bukti telah selamat dihantar ke dalam sistem!');
    }

    /**
     * Mengemaskini Maklumat Peribadi Pengadu di Supabase
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'name' => $request->input('name'),
                'updated_at' => now(),
            ]);

        return redirect('/user')->with('success', 'Maklumat profil anda telah berjaya dikemaskini!');
    }

    /**
     * Memproses Penukaran Kata Laluan (Password) Baru
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->input('current_password'), $user->password)) {
            return redirect('/user')->with('success', 'Ralat: Kata laluan semasa anda adalah salah!');
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => \Hash::make($request->input('new_password')),
                'updated_at' => now(),
            ]);

        return redirect('/user')->with('success', 'Kata laluan akaun anda telah berjaya ditukar!');
    }
}