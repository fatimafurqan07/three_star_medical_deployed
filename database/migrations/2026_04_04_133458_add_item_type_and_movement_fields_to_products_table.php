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

            if (!Schema::hasColumn('products', 'is_fridge')) {

                $table->boolean('is_fridge')->default(false);

            }

            if (!Schema::hasColumn('products', 'is_non_fridge')) {

                $table->boolean('is_non_fridge')->default(false);

            }

            if (!Schema::hasColumn('products', 'is_fast_moving')) {

                $table->boolean('is_fast_moving')->default(false);

            }

            if (!Schema::hasColumn('products', 'is_slow_moving')) {

                $table->boolean('is_slow_moving')->default(false);

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
            $table->dropColumn(['is_fridge', 'is_non_fridge', 'is_fast_moving', 'is_slow_moving']);
            });
}
    }
};
