<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('referensis', function (Blueprint $t) {
            $t->string('kata_kunci', 500)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('referensis', function (Blueprint $t) {
            $t->dropColumn('kata_kunci');
        });
    }
};
