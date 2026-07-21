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
        if (Schema::hasTable('hr_employees')) {
    Schema::table('hr_employees', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_employees', 'weekly_off')) {

                $table->string('weekly_off')->nullable()->after('address');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_employees')) {
    Schema::table('hr_employees', function (Blueprint $table) {
            if (Schema::hasColumn('hr_employees', 'weekly_off')) {
                $table->dropColumn('weekly_off');
            }
            });
}
    }
};
