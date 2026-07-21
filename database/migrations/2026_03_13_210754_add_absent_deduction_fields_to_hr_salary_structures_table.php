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

            if (!Schema::hasColumn('hr_salary_structures', 'absent_deduction_type')) {

                $table->string('absent_deduction_type')->default('manual')->after('leave_salary_per_day');

            }
            // We can reuse leave_salary_per_day for the amount, or add a separate one if needed.
            // The user said "if user select manul than field will be ediable and user can itner value".
            // Since leave_salary_per_day is already there, I will just add the type.
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
            $table->dropColumn('absent_deduction_type');
            });
}
    }
};
