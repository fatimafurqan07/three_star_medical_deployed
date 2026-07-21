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

            if (!Schema::hasColumn('warehouse_stocks', 'loose_pieces')) {

                $table->integer('loose_pieces')->default(0)->after('quantity');

            }

            if (!Schema::hasColumn('warehouse_stocks', 'boxes_quantity')) {

                $table->integer('boxes_quantity')->default(0)->after('quantity');

            }

            if (!Schema::hasColumn('warehouse_stocks', 'pieces_per_box')) {

                $table->integer('pieces_per_box')->default(0)->after('quantity');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('warehouse_stocks')) {
    Schema::table('warehouse_stocks', function (Blueprint $table) {
            $table->dropColumn(['loose_pieces', 'boxes_quantity', 'pieces_per_box']);
            });
}
    }
};
