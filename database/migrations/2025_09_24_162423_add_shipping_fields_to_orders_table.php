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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('ship_to_name')->nullable()->after('tax_amount');
            $table->string('ship_to_address')->nullable()->after('ship_to_name');
            $table->text('notes')->nullable()->after('ship_to_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['ship_to_name', 'ship_to_address', 'notes']);
        });
    }
};
