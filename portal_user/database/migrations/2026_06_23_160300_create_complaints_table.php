<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membina semula table complaints dari kosong.
     */
    public function up(): void
    {
        // Padam table lama di Supabase jika tersangkut atau rosak
        Schema::dropIfExists('complaints');

        // Bina semula table dengan struktur penuh yang dimahukan oleh Admin
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Menghubungkan aduan dengan ID pengguna (No Matrik/Staff)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Tajuk Isu Aduan
            $table->string('title');
            // ID Kategori daripada Admin (Dibuat string/nullable sebagai pelindung ralat)
            $table->string('category_id')->nullable();
            // Tarikh Kejadian
            $table->date('complaint_date')->nullable();
            // Masa Kejadian
            $table->time('complaint_time')->nullable();
            // Lokasi Detail (Blok, Aras, Bilik)
            $table->string('location')->nullable();
            // Deskripsi Penjelasan Aduan
            $table->text('description');
            // Status Aduan (Default automatik 'baru')
            $table->string('status')->default('baru');

            // Bukti (evidence)
            // - evidence_photo: single image (legacy)
            // - evidence_photos: multiple images (JSON array of filenames/paths)
            $table->string('evidence_photo')->nullable();
            $table->json('evidence_photos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Padam table jika migrasi ditarik balik.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};