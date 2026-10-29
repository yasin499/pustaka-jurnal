<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_targets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('nama');
            $t->string('url')->nullable();
            $t->string('jenis_biaya')->default('belum_diketahui');
            $t->unsignedBigInteger('biaya')->nullable();
            $t->string('periode_terbit')->nullable();
            $t->string('indeks')->nullable();
            $t->boolean('indeks_terverifikasi')->default(false);
            $t->text('catatan')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_targets');
    }
};
