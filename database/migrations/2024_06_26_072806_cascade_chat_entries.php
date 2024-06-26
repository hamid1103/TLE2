<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('chat_entries', function (Blueprint $table) {
            $table->dropForeign(['chat_history_id']);
            $table->foreign('chat_history_id')->references('id')->on('chat_histories')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chat_entries', function (Blueprint $table) {
            //
        });
    }
};
