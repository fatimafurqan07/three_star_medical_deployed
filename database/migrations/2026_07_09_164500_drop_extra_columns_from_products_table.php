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
        if (Schema::hasTable('products')) {
    Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'height',
                'width',
                'total_m2',
                'pieces_per_m2',
                'price_per_m2',
                'purchase_price_per_m2',
                'boxes_quantity',
                'loose_pieces',
                'piece_quantity',
                'total_stock_qty',
            ]);
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('products')) {
    Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'height')) {

                $table->decimal('height', 8, 2)->nullable();

            }

            if (!Schema::hasColumn('products', 'width')) {

                $table->decimal('width', 8, 2)->nullable();

            }

            if (!Schema::hasColumn('products', 'total_m2')) {

                $table->decimal('total_m2', 10, 2)->nullable();

            }

            if (!Schema::hasColumn('products', 'pieces_per_m2')) {

                $table->decimal('pieces_per_m2', 10, 2)->default(0.00);

            }

            if (!Schema::hasColumn('products', 'price_per_m2')) {

                $table->decimal('price_per_m2', 12, 2)->default(0.00);

            }

            if (!Schema::hasColumn('products', 'purchase_price_per_m2')) {

                $table->decimal('purchase_price_per_m2', 12, 2)->default(0.00);

            }

            if (!Schema::hasColumn('products', 'boxes_quantity')) {

                $table->integer('boxes_quantity')->default(0)->nullable();

            }

            if (!Schema::hasColumn('products', 'loose_pieces')) {

                $table->integer('loose_pieces')->default(0)->nullable();

            }

            if (!Schema::hasColumn('products', 'piece_quantity')) {

                $table->integer('piece_quantity')->default(0)->nullable();

            }

            if (!Schema::hasColumn('products', 'total_stock_qty')) {

                $table->decimal('total_stock_qty', 10, 2)->default(0.00)->nullable();

            }
            });
}
    }
};
