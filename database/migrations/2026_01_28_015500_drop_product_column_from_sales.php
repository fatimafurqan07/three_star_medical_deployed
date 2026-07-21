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
            if (Schema::hasColumn('sales', 'product')) {
                $table->dropColumn('product');
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
            // Restore as nullable text if rolled back

            if (!Schema::hasColumn('sales', 'product')) {

                $table->text('product')->nullable();

            }
            });
}
    }
};
