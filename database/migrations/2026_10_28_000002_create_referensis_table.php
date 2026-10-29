<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referensis', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('jurnal_target_id')->nullable()->constrained('jurnal_targets')->nullOnDelete();
            $t->string('judul', 500);
            $t->string('penulis', 300)->nullable();
            $t->unsignedSmallInteger('tahun')->nullable();
            $t->string('url_artikel', 500)->nullable();
            $t->string('file_pdf')->nullable();
            $t->string('status')->default('belum_dibaca');
            $t->text('metode')->nullable();
            $t->string('kelengkapan_metode')->nullable();
            $t->text('permasalahan')->nullable();
            $t->text('temuan')->nullable();
            $t->text('keterbatasan')->nullable();
            $t->text('catatan')->nullable();
            $t->unsignedTinyInteger('relevansi')->nullable();
            $t->string('tags', 300)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referensis');
    }
};
