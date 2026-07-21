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

            if (!Schema::hasColumn('hr_salary_structures', 'attendance_deduction_policy')) {

                $table->json('attendance_deduction_policy')->nullable()->after('deductions');

            }

            if (!Schema::hasColumn('hr_salary_structures', 'carry_forward_deductions')) {

                $table->boolean('carry_forward_deductions')->default(false)->after('attendance_deduction_policy');

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
            $table->dropColumn(['attendance_deduction_policy', 'carry_forward_deductions']);
            });
}
    }
};
