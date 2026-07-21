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
            $table->dropColumn('price');
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

            if (!Schema::hasColumn('warehouse_stocks', 'price')) {

                $table->decimal('price', 12, 2)->nullable();

            }
            });
}
    }
};
