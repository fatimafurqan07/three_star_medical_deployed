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

            if (!Schema::hasColumn('purchase_items', 'item_discount_type')) {

                $table->string('item_discount_type')->default('amount')->after('item_discount');

            }
            });
}

        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {

            if (!Schema::hasColumn('purchases', 'discount_type')) {

                $table->string('discount_type')->default('amount')->after('discount');

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
            $table->dropColumn('item_discount_type');
            });
}

        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            });
}
    }
};
