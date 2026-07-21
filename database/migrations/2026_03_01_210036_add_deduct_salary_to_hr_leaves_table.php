<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hr_leaves')) {
    Schema::table('hr_leaves', function (Blueprint $table) {
            // Whether to deduct salary for this leave day(s)
            // Default: false (no deduction) — HR can tick to force deduction
            // Gets auto-forced (true) when employee has exhausted their quota

            if (!Schema::hasColumn('hr_leaves', 'deduct_salary')) {

                $table->boolean('deduct_salary')->default(false)->after('reason');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('hr_leaves')) {
    Schema::table('hr_leaves', function (Blueprint $table) {
            $table->dropColumn('deduct_salary');
            });
}
    }
};
