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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedInteger('nights')->default(1);
            $table->unsignedInteger('adults')->default(2);
            $table->unsignedInteger('children')->default(0);
            $table->unsignedInteger('total_price')->default(0);
            $table->string('status')->default('pending');
            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
