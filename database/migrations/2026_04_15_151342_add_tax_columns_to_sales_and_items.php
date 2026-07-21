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

            if (!Schema::hasColumn('sales', 'total_inc_tax')) {

                $table->decimal('total_inc_tax', 15, 2)->default(0);

            }

            if (!Schema::hasColumn('sales', 'total_adv_tax')) {

                $table->decimal('total_adv_tax', 15, 2)->default(0);

            }
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_items', 'inc_tax')) {

                $table->decimal('inc_tax', 15, 2)->default(0);

            }

            if (!Schema::hasColumn('sale_items', 'adv_tax')) {

                $table->decimal('adv_tax', 15, 2)->default(0);

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
            $table->dropColumn(['total_inc_tax', 'total_adv_tax']);
            });
}

        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['inc_tax', 'adv_tax']);
            });
}
    }
};
