<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_entries', function (Blueprint $table) {
            $table->id();
            $table->string('Sender');
            $table->longText('Content');
            $table->unsignedBigInteger('chat_history_id');
            $table->foreign('chat_history_id')->references('id')->on('chat_histories');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_entries');
    }
};
