<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_amount', 10, 2)->default(0)->after('status');
            $table->decimal('shipping_amount', 10, 2)->default(0)->after('subtotal_amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('shipping_amount');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal_amount', 'shipping_amount', 'tax_amount']);
        });
    }
};
