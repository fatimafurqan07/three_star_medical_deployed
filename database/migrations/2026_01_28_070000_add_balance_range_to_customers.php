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
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'balance_range')) {

                if (!Schema::hasColumn('customers', 'balance_range')) {

                    $table->decimal('balance_range', 12, 2)->default(0)->after('opening_balance');

                }
            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'balance_range')) {
                $table->dropColumn('balance_range');
            }
            });
}
    }
};
