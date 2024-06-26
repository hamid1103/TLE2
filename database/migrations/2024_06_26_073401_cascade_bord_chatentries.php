<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bord_chatentries', function (Blueprint $table) {
            $table->dropForeign(['chat_entry_id']);
            $table->foreign('chat_entry_id')->references('id')->on('chat_entries')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bord_chatentries', function (Blueprint $table) {
            //
        });
    }
};
