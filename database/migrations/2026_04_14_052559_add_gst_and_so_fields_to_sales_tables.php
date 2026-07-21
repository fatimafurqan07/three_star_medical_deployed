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

            if (!Schema::hasColumn('sales', 'total_gst')) {

                $table->decimal('total_gst', 15, 2)->default(0)->after('total_bill_amount');

            }

            if (!Schema::hasColumn('sales', 'sale_order_no')) {

                $table->string('sale_order_no')->nullable()->after('invoice_no');

            }

            if (!Schema::hasColumn('sales', 'so_date')) {

                $table->date('so_date')->nullable()->after('sale_order_no');

            }
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_items', 'gst_percent')) {

                $table->decimal('gst_percent', 8, 2)->default(0)->after('discount_amount');

            }

            if (!Schema::hasColumn('sale_items', 'gst_amount')) {

                $table->decimal('gst_amount', 15, 2)->default(0)->after('gst_percent');

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
            $table->dropColumn(['total_gst', 'sale_order_no', 'so_date']);
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['gst_percent', 'gst_amount']);
            });
}
    }
};
