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

            if (!Schema::hasColumn('products', 'model')) {

                $table->string('model')->nullable();

            }

            if (!Schema::hasColumn('products', 'hs_code')) {

                $table->string('hs_code')->nullable();

            }

            if (!Schema::hasColumn('products', 'pack_type')) {

                $table->string('pack_type')->nullable();

            }

            if (!Schema::hasColumn('products', 'pack_qty')) {

                $table->string('pack_qty')->nullable();

            }

            if (!Schema::hasColumn('products', 'piece_per_pack')) {

                $table->string('piece_per_pack')->nullable();

            }

            if (!Schema::hasColumn('products', 'loose_piece')) {

                $table->string('loose_piece')->nullable();

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
            
            });
}
    }
};
