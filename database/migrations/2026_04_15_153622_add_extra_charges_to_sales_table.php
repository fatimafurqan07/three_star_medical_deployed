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

            if (!Schema::hasColumn('sales', 'total_freight')) {

                $table->decimal('total_freight', 15, 2)->default(0)->after('total_extradiscount');

            }

            if (!Schema::hasColumn('sales', 'total_expense')) {

                $table->decimal('total_expense', 15, 2)->default(0)->after('total_freight');

            }

            if (!Schema::hasColumn('sales', 'total_fixed_tax')) {

                $table->decimal('total_fixed_tax', 15, 2)->default(0)->after('total_expense');

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
            $table->dropColumn(['total_freight', 'total_expense', 'total_fixed_tax']);
            });
}
    }
};
