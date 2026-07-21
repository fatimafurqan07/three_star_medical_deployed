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

            if (!Schema::hasColumn('hr_salary_structures', 'effective_date')) {

                $table->date('effective_date')->nullable()->after('leave_salary_per_day');

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
            //
            });
}
    }
};
