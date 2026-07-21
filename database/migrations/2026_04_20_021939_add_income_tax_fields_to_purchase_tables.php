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
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'is_gst_invoice')) {

                if (!Schema::hasColumn('purchases', 'is_gst_invoice')) {

                    $table->boolean('is_gst_invoice')->default(0)->after('invoice_no');

                }
            }
            });
}

        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_items', 'it_percent')) {

                if (!Schema::hasColumn('purchase_items', 'it_percent')) {

                    $table->decimal('it_percent', 12, 2)->default(0)->after('gst_amount');

                }
            }
            if (!Schema::hasColumn('purchase_items', 'adv_tax_percent')) {

                if (!Schema::hasColumn('purchase_items', 'adv_tax_percent')) {

                    $table->decimal('adv_tax_percent', 12, 2)->default(0)->after('it_percent');

                }
            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('is_gst_invoice');
            });
}

        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['it_percent', 'adv_tax_percent']);
            });
}
    }
};
