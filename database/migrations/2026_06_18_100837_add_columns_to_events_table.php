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
        Schema::table('events', function (Blueprint $table) {
            $table->string('badge')->nullable()->after('order');
            $table->string('badge_color')->nullable()->after('badge');
            $table->json('features')->nullable()->after('badge_color');
            $table->string('slug')->unique()->nullable()->after('features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['badge', 'badge_color', 'features', 'slug']);
        });
    }
};
