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
        Schema::table('reservasi', function (Blueprint $table) {
            $table->string('smoking_preference')->nullable()->after('children');
            $table->string('bed_setup')->nullable()->after('smoking_preference');
            $table->text('special_requests')->nullable()->after('bed_setup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->dropColumn(['smoking_preference', 'bed_setup', 'special_requests']);
        });
    }
};
