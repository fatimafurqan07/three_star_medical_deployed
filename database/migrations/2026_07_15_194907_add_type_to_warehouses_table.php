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
        if (Schema::hasTable('warehouses')) {
    Schema::table('warehouses', function (Blueprint $table) {

            if (!Schema::hasColumn('warehouses', 'type')) {

                $table->enum('type', ['warehouse', 'shop'])->default('warehouse')->after('warehouse_name');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('warehouses')) {
    Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('type');
            });
}
    }
};
