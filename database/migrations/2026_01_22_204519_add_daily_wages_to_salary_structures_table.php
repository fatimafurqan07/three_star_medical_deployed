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

            if (!Schema::hasColumn('hr_salary_structures', 'daily_wages')) {

                $table->decimal('daily_wages', 10, 2)->nullable()->after('base_salary');

            }

            if (!Schema::hasColumn('hr_salary_structures', 'use_daily_wages')) {

                $table->boolean('use_daily_wages')->default(false)->after('daily_wages');

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
            $table->dropColumn(['daily_wages', 'use_daily_wages']);
            });
}
    }
};
