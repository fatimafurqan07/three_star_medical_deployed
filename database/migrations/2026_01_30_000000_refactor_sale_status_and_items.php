<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update sales table status
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            // First ensure we don't have invalid statuses (map old to new)
            // draft -> booked, posted -> posted, 1 -> returned
            // We can do this via raw SQL update before changing column type
            });
}

        // Update data first
        DB::statement("UPDATE sales SET sale_status = 'booked' WHERE sale_status = 'draft' OR sale_status IS NULL");
        DB::statement("UPDATE sales SET sale_status = 'returned' WHERE sale_status = '1'");

        // Modify column to ENUM
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            // Drop enum constraint if it exists (DB specific, but safe to just change type to string/enum)
            // For flexibility, we'll use string with constrained values in app logic,
            // or explicit ENUM in DB. User asked for ENUM.

            if (!Schema::hasColumn('sales', 'sale_status')) {

                $table->enum('sale_status', ['booked', 'posted', 'cancelled', 'returned'])->default('booked')->change();

            }
            });
}

        // 2. Update sale_items table
        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            if (! Schema::hasColumn('sale_items', 'product_name')) {

                if (!Schema::hasColumn('sale_items', 'product_name')) {

                    $table->string('product_name', 255)->nullable()->after('product_id');

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
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            // Revert is hard as we lost original mapping, but we can change back to string

            if (!Schema::hasColumn('sales', 'sale_status')) {

                $table->string('sale_status')->change();

            }
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            if (Schema::hasColumn('sale_items', 'product_name')) {
                $table->dropColumn('product_name');
            }
            });
}
    }
};
