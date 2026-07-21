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
        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {

            if (!Schema::hasColumn('purchase_items', 'gst_percent')) {

                $table->decimal('gst_percent', 12, 2)->default(0)->after('item_discount');

            }

            if (!Schema::hasColumn('purchase_items', 'gst_amount')) {

                $table->decimal('gst_amount', 12, 2)->default(0)->after('gst_percent');

            }
            });
}

        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {

            if (!Schema::hasColumn('purchases', 'total_gst')) {

                $table->decimal('total_gst', 12, 2)->default(0)->after('extra_cost');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['gst_percent', 'gst_amount']);
            });
}

        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('total_gst');
            });
}
    }
};
