<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', length: 100);
            $table->text('deskripsi');
            $table->text('lokasi');
            $table->string('jam_masuk', length: 100);
            $table->string('jam_pulang', length: 100);
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_perusahaan');
    }
};