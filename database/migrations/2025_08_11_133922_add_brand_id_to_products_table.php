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

             if (!Schema::hasColumn('products', 'brand_id')) {

                 $table->unsignedBigInteger('brand_id')->nullable()->after('sub_category_id');

             }

               $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands')
                  ->onDelete('set null'); // agar brand delete ho to null ho jaye            //
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
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
            });
}
    }
};
