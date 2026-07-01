<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

class ComplaintController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil kategori admin secara fleksibel
        $admin_categories = [];
        if (Schema::hasTable('categories')) {
            $admin_categories = DB::table('categories')->get();
        } elseif (Schema::hasTable('complaint_categories')) {
            $admin_categories = DB::table('complaint_categories')->get();
        } elseif (Schema::hasTable('kategori')) {
            $admin_categories = DB::table('kategori')->get();
        }

        // 2. Statistik kes
        $total = DB::table('complaints')->where('user_id', $userId)->count();
        $total_baru = DB::table('complaints')->where('user_id', $userId)->whereIn('status', ['baru', 'Baru', 'new', 'New', 'BARU', 'pending', 'Pending'])->count();
        $pending = DB::table('complaints')->where('user_id', $userId)->whereIn('status', ['dalam proses', 'Dalam Proses', 'proses', 'PROSES'])->count();
        $investigation = DB::table('complaints')->where('user_id', $userId)->whereIn('status', ['investigation', 'Investigation', 'siasatan', 'Siasatan', 'SIASATAN', 'dalam siasatan'])->count();
        $total_selesai = DB::table('complaints')->where('user_id', $userId)->whereIn('status', ['selesai', 'Selesai', 'resolved', 'Resolved', 'completed', 'Completed', 'SELESAI'])->count();

        // Ambil semua data aduan untuk dipaparkan dalam jadual/dashboard
        $complaints = DB::table('complaints')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        // Hantar $complaints sekali ke view
        return view('complaints.index', compact('total', 'total_baru', 'pending', 'investigation', 'total_selesai', 'admin_categories', 'complaints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|string',
            'complaint_date' => 'required|date',
            'complaint_time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'required|string',

            // Legacy single upload (not used by UI, but keep compatible)
            'evidence_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $singlePhotoRef = null;
            $multiPhotoRefs = [];

            $supabaseUrl = rtrim((string) config('services.supabase.url'), '/');
            $serviceRoleKey = (string) config('services.supabase.service_role_key');
            $bucket = (string) config('services.supabase.storage_bucket', 'evidence');

            if (empty($supabaseUrl) || empty($serviceRoleKey) || empty($bucket)) {
                return redirect()
                    ->back()
                    ->withErrors(['submit_error' => 'Konfigurasi Supabase tidak lengkap. Sila semak SUPABASE_URL, SUPABASE_SERVICE_ROLE_KEY dan SUPABASE_STORAGE_BUCKET dalam .env'])
                    ->withInput();
            }

            // Legacy single image
            if ($request->hasFile('evidence_photo')) {
                $file = $request->file('evidence_photo');
                if ($file && $file->isValid()) {
                    $path = $this->uploadFileToSupabase($file, $supabaseUrl, $serviceRoleKey, $bucket, Auth::id());
                    $singlePhotoRef = $path;
                }
            }

            // New multiple images (manual validation to avoid generic "failed to upload" validation popup)
            $rawFiles = $request->file('evidence_photos', []);
            $validFiles = [];

            if ($rawFiles instanceof \Illuminate\Http\UploadedFile) {
                $rawFiles = [$rawFiles];
            }

            if (!is_array($rawFiles)) {
                $rawFiles = [];
            }

            foreach ($rawFiles as $idx => $file) {
                if (!$file instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                if (!$file->isValid()) {
                    $errCode = $file->getError();
                    
                    // Error code 1 = UPLOAD_ERR_INI_SIZE - file exceeds php.ini upload_max_filesize
                    if ($errCode === UPLOAD_ERR_INI_SIZE) {
                        $maxSize = ini_get('upload_max_filesize');
                        $maxSizeMB = round($maxSize / (1024 * 1024), 1);
                        $errMsg = 'Fail bukti #' . ($idx + 1) . ' melebihi saiz muat naik (' . $maxSizeMB . 'MB). Sila kecilkan gambar atau semak tetapan php.ini.';
                        return redirect()->back()->withErrors(['evidence_photos.' . $idx => $errMsg])->withInput();
                    }
                    
                    // Error code 2 = UPLOAD_ERR_FORM_SIZE - file exceeds MAX_FILE_SIZE form field
                    if ($errCode === UPLOAD_ERR_FORM_SIZE) {
                        $errMsg = 'Fail bukti #' . ($idx + 1) . ' melebihi had saiz yang ditetapkan dalam borang (2MB).';
                        return redirect()->back()->withErrors(['evidence_photos.' . $idx => $errMsg])->withInput();
                    }
                    
                    $errMsg = 'Fail bukti #' . ($idx + 1) . ' gagal dimuat naik (kod: ' . $errCode . ').';
                    return redirect()->back()->withErrors(['evidence_photos.' . $idx => $errMsg])->withInput();
                }

                $size = (int) $file->getSize();
                if ($size > 2 * 1024 * 1024) {
                    return redirect()->back()->withErrors(['evidence_photos.' . $idx => 'Fail bukti #' . ($idx + 1) . ' melebihi 2MB.'])->withInput();
                }

                $mime = strtolower((string) $file->getClientMimeType());
                $ext = strtolower((string) $file->getClientOriginalExtension());

                $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($mime, $allowedMimes, true) && !in_array($ext, $allowedExts, true)) {
                    return redirect()->back()->withErrors(['evidence_photos.' . $idx => 'Format fail bukti #' . ($idx + 1) . ' tidak dibenarkan.'])->withInput();
                }

                $validFiles[] = $file;
            }

            if (!empty($validFiles)) {
                $refs = [];

                foreach ($validFiles as $file) {
                    $path = $this->uploadFileToSupabase($file, $supabaseUrl, $serviceRoleKey, $bucket, Auth::id());
                    $refs[] = $path;
                }

                $multiPhotoRefs = $refs;

                // Compatibility: also fill legacy single evidence_photo with the first image
                if (!empty($multiPhotoRefs) && empty($singlePhotoRef)) {
                    $singlePhotoRef = $multiPhotoRefs[0];
                }
            }

            // Masukkan data ke database
            DB::table('complaints')->insert([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'category_id' => $request->category_id,
                'complaint_date' => $request->complaint_date,
                'complaint_time' => $request->complaint_time,
                'location' => $request->location,
                'description' => $request->description,
                'status' => 'baru',

                // Legacy (always set if any photo exists) - now stores Supabase object path
                'evidence_photo' => $singlePhotoRef,

                // Multiple evidence (stored as JSON array of Supabase object paths)
                'evidence_photos' => !empty($multiPhotoRefs) ? json_encode($multiPhotoRefs) : null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('complaints.index')->with('success', 'Aduan baharu berjaya dihantar!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withErrors(['submit_error' => 'Gagal simpan aduan bergambar: ' . $e->getMessage()])
                ->withInput();
        }
    }

    private function uploadFileToSupabase(\Illuminate\Http\UploadedFile $file, string $supabaseUrl, string $serviceRoleKey, string $bucket, $userId): string
    {
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $safeExt = $extension !== '' ? $extension : 'jpg';
        // Simplified: semua gambar dalam satu folder saja - complaints/{userId}/
        $objectPath = 'complaints/' . $userId . '/' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $safeExt;

        $uploadUrl = $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $objectPath;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $serviceRoleKey,
            'apikey' => $serviceRoleKey,
            'Content-Type' => $file->getMimeType() ?: 'application/octet-stream',
            'x-upsert' => 'false',
        ])->withBody(file_get_contents($file->getRealPath()), $file->getMimeType() ?: 'application/octet-stream')
          ->post($uploadUrl);

        if (!$response->successful()) {
            throw new \RuntimeException('Supabase upload gagal: HTTP ' . $response->status() . ' - ' . $response->body());
        }

        return $objectPath;
    }
}
