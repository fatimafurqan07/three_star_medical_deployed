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

            if (!Schema::hasColumn('purchase_items', 'uom_name')) {

                $table->string('uom_name')->nullable()->after('product_id');

            }

            if (!Schema::hasColumn('purchase_items', 'uom_factor')) {

                $table->decimal('uom_factor', 18, 4)->default(1)->after('uom_name');

            }
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_items', 'uom_name')) {

                $table->string('uom_name')->nullable()->after('product_name');

            }

            if (!Schema::hasColumn('sale_items', 'uom_factor')) {

                $table->decimal('uom_factor', 18, 4)->default(1)->after('uom_name');

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
            $table->dropColumn(['uom_name', 'uom_factor']);
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['uom_name', 'uom_factor']);
            });
}
    }
};
