<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // No schema change needed if sender_id and receiver_id already exist, but add index for performance
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->index(['sender_id', 'receiver_id']);
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropIndex(['sender_id', 'receiver_id']);
        });
    }
};
