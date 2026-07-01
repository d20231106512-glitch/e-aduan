<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

test('authenticated user can submit complaint with image evidence', function () {
    // Ensure directory exists for move() destination used by controller
    $targetDir = public_path('uploads/evidence/complaints');
    if (! File::exists($targetDir)) {
        File::makeDirectory($targetDir, 0775, true);
    }

    $user = User::factory()->create();
    $this->actingAs($user);

    $payload = [
        'title' => 'Ujian Bukti Gambar',
        'category_id' => 'Kecurian',
        'complaint_date' => now()->toDateString(),
        'complaint_time' => now()->format('H:i'),
        'location' => 'Blok A',
        'description' => 'Ujian hantar aduan bersama gambar.',
        'evidence_photos' => [
            UploadedFile::fake()->image('bukti.jpg', 1200, 900)->size(713),
        ],
    ];

    $response = $this->post(route('complaints.store'), $payload);

    $response->assertRedirect(route('complaints.index'));

    $complaint = DB::table('complaints')
        ->where('user_id', $user->id)
        ->where('title', 'Ujian Bukti Gambar')
        ->latest('id')
        ->first();

    expect($complaint)->not->toBeNull();
    expect($complaint->evidence_photo)->not->toBeNull();
    expect($complaint->evidence_photos)->not->toBeNull();

    $photos = json_decode($complaint->evidence_photos, true);
    expect(is_array($photos))->toBeTrue();
    expect(count($photos))->toBeGreaterThan(0);

    // File is physically moved to public/uploads/evidence/complaints
    expect(File::exists($targetDir . DIRECTORY_SEPARATOR . basename($photos[0])))->toBeTrue();
});

test('complaint upload rejects non-image file', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $payload = [
        'title' => 'Ujian Fail Tak Sah',
        'category_id' => 'Lain-lain',
        'complaint_date' => now()->toDateString(),
        'complaint_time' => now()->format('H:i'),
        'location' => 'Blok B',
        'description' => 'Ujian fail bukan imej.',
        'evidence_photos' => [
            UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
        ],
    ];

    $response = $this->from(route('complaints.index'))
        ->post(route('complaints.store'), $payload);

    $response->assertRedirect(route('complaints.index'));
    $response->assertSessionHasErrors('evidence_photos.0');
});
