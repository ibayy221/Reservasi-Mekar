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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nik_ktp')) {
                $table->string('nik_ktp')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('nik_ktp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            if (Schema::hasColumn('users', 'nik_ktp')) {
                $table->dropColumn('nik_ktp');
            }
        });
    }
};
