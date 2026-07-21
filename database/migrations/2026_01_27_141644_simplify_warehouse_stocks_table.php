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
        if (Schema::hasTable('warehouse_stocks')) {
    Schema::table('warehouse_stocks', function (Blueprint $table) {
            $table->dropColumn(['boxes_quantity', 'loose_pieces']);
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('warehouse_stocks')) {
    Schema::table('warehouse_stocks', function (Blueprint $table) {

            if (!Schema::hasColumn('warehouse_stocks', 'boxes_quantity')) {

                $table->integer('boxes_quantity')->default(0)->after('quantity');

            }

            if (!Schema::hasColumn('warehouse_stocks', 'loose_pieces')) {

                $table->integer('loose_pieces')->default(0)->after('quantity');

            }
            });
}
    }
};
