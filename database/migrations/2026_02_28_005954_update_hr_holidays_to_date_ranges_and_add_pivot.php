<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hr_holidays')) {
    Schema::table('hr_holidays', function (Blueprint $table) {
            $table->dropUnique(['date']);

            if (!Schema::hasColumn('hr_holidays', 'end_date')) {

                $table->date('end_date')->nullable()->after('date');

            }
            });
}

        Schema::create('hr_employee_holiday', function (Blueprint $table) {
            $table->id();
            $table->foreignId('holiday_id')->constrained('hr_holidays')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('hr_employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_employee_holiday');

        if (Schema::hasTable('hr_holidays')) {
    Schema::table('hr_holidays', function (Blueprint $table) {
            $table->dropColumn('end_date');
            // Adding back the unique, though it might fail if there are duplicates from the new changes
            $table->unique('date');
            });
}
    }
};
