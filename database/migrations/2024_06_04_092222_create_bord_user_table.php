<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bord_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('bord_id');
            $table->foreign('bord_id')->references('id')->on('bords');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bord_users');
    }
};
