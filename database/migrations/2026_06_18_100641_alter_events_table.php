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
            $table->string('title')->after('id');
            $table->text('description')->after('title');
            $table->string('image')->nullable()->after('description');
            $table->string('badge')->after('image');
            $table->string('badge_color')->after('badge');
            $table->json('features')->nullable()->after('badge_color');
            $table->string('slug')->unique()->after('features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'image', 'badge', 'badge_color', 'features', 'slug']);
        });
    }
};
