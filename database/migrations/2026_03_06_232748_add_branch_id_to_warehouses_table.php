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
        if (! Schema::hasColumn('warehouses', 'branch_id')) {
            if (Schema::hasTable('warehouses')) {
    Schema::table('warehouses', function (Blueprint $table) {

                if (!Schema::hasColumn('warehouses', 'branch_id')) {

                    $table->unsignedBigInteger('branch_id')->nullable()->default(1)->after('id');

                }
                });
}
        }

        if (! Schema::hasColumn('warehouse_stocks', 'branch_id')) {
            if (Schema::hasTable('warehouse_stocks')) {
    Schema::table('warehouse_stocks', function (Blueprint $table) {

                if (!Schema::hasColumn('warehouse_stocks', 'branch_id')) {

                    $table->unsignedBigInteger('branch_id')->nullable()->default(1)->after('warehouse_id');

                }
                });
}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('warehouses')) {
    Schema::table('warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('warehouses', 'branch_id')) {
                $table->dropColumn('branch_id');
            }
            });
}

        if (Schema::hasTable('warehouse_stocks')) {
    Schema::table('warehouse_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('warehouse_stocks', 'branch_id')) {
                $table->dropColumn('branch_id');
            }
            });
}
    }
};
