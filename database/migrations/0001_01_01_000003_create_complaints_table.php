<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category'); // theft, harassment, accident, pencerobohan, jalan raya
            $table->string('evidence_url')->nullable();
            $table->date('incident_date');
            $table->time('incident_time');
            $table->string('location'); // e.g., Block KSAS
            $table->text('description');
            $table->string('status')->default('Pending'); // Pending, Investigating, Resolved
            $table->boolean('is_emergency')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};