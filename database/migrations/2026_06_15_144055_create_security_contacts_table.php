<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('security_contacts')) {
            Schema::create('security_contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone_number');
                $table->string('zone_assignment')->nullable(); // e.g., Blok Kampus Baru, KSAS Gate
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('security_contacts');
    }
};
