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
            //

            if (!Schema::hasColumn('products', 'initial_stock')) {

                $table->text('initial_stock')->nullable();

            }

            if (!Schema::hasColumn('products', 'wholesale_price')) {

                $table->text('wholesale_price')->nullable();

            }

        if (!Schema::hasColumn('products', 'image')) {

            $table->string('image',255)->nullable();

        }

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
            //
             $table->dropColumn([
            'wholesale_price',
            'initial_stock',
            'image'
        ]);
            });
}
    }
};
