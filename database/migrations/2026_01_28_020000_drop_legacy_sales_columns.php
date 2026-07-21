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
            $columns = [
                'product_code', 'brand', 'unit', 'per_price', 'per_discount',
                'qty', 'per_total', 'color',
                'per_total_pieces', 'per_price_per_piece', 'per_price_per_m2', 'per_loose_pieces',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('sales', $column)) {
                    $table->dropColumn($column);
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
            // Restore as nullable text

            if (!Schema::hasColumn('sales', 'product_code')) {

                $table->text('product_code')->nullable();

            }

            if (!Schema::hasColumn('sales', 'brand')) {

                $table->text('brand')->nullable();

            }

            if (!Schema::hasColumn('sales', 'unit')) {

                $table->text('unit')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_price')) {

                $table->text('per_price')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_discount')) {

                $table->text('per_discount')->nullable();

            }

            if (!Schema::hasColumn('sales', 'qty')) {

                $table->text('qty')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_total')) {

                $table->text('per_total')->nullable();

            }

            if (!Schema::hasColumn('sales', 'color')) {

                $table->text('color')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_total_pieces')) {

                $table->text('per_total_pieces')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_price_per_piece')) {

                $table->text('per_price_per_piece')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_price_per_m2')) {

                $table->text('per_price_per_m2')->nullable();

            }

            if (!Schema::hasColumn('sales', 'per_loose_pieces')) {

                $table->text('per_loose_pieces')->nullable();

            }
            });
}
    }
};
