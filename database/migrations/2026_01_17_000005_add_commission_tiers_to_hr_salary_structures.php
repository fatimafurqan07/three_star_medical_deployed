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
        if (Schema::hasTable('hr_salary_structures')) {
    Schema::table('hr_salary_structures', function (Blueprint $table) {
            // Commission tiers (JSON for tiered commission)
            // Format: [{"percentage": 2, "upto_amount": 10000}, {"percentage": 5, "upto_amount": 20000}]

            if (!Schema::hasColumn('hr_salary_structures', 'commission_tiers')) {

                $table->json('commission_tiers')->nullable()->after('sales_target');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_salary_structures')) {
    Schema::table('hr_salary_structures', function (Blueprint $table) {
            $table->dropColumn('commission_tiers');
            });
}
    }
};
