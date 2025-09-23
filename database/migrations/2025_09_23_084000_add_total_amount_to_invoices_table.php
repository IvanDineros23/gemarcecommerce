<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('total_amount', 15, 2)->default(0)->after('balance_due');
        });
    }
    public function down(): void {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }
};
