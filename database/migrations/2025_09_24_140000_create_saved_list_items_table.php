<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('saved_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saved_list_id')->constrained('saved_lists')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['saved_list_id', 'product_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('saved_list_items');
    }
};
