<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kamar_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kamar_id');
            $table->date('date');
            $table->integer('available')->default(0);
            $table->timestamps();

            $table->foreign('kamar_id')->references('id')->on('kamar')->onDelete('cascade');
            $table->unique(['kamar_id','date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar_availabilities');
    }
};
