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
                'boxes_quantity',
                'loose_pieces',
                'piece_quantity',
                'total_stock_qty',
                'total_price',
                'total_purchase_price',
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

            if (!Schema::hasColumn('products', 'boxes_quantity')) {

                $table->integer('boxes_quantity')->nullable();

            }

            if (!Schema::hasColumn('products', 'loose_pieces')) {

                $table->integer('loose_pieces')->nullable();

            }

            if (!Schema::hasColumn('products', 'piece_quantity')) {

                $table->integer('piece_quantity')->nullable();

            }

            if (!Schema::hasColumn('products', 'total_stock_qty')) {

                $table->integer('total_stock_qty')->nullable();

            }

            if (!Schema::hasColumn('products', 'total_price')) {

                $table->decimal('total_price', 15, 2)->nullable();

            }

            if (!Schema::hasColumn('products', 'total_purchase_price')) {

                $table->decimal('total_purchase_price', 15, 2)->nullable();

            }
            });
}
    }
};
