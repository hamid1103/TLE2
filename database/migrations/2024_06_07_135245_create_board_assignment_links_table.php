<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('board_assignment_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id');
            $table->foreign('board_id')->references('id')->on('bords');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('board__assignment__links');
    }
};
