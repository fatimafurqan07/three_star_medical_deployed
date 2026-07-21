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
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {

            if (!Schema::hasColumn('sales', 'sale_date')) {

                $table->date('sale_date')->nullable()->after('invoice_no');

            }

            if (!Schema::hasColumn('sales', 'vendor_bill_no')) {

                $table->string('vendor_bill_no')->nullable()->after('sale_order_no');

            }

            if (!Schema::hasColumn('sales', 'order_no')) {

                $table->string('order_no')->nullable()->after('vendor_bill_no');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['sale_date', 'vendor_bill_no', 'order_no']);
            });
}
    }
};
