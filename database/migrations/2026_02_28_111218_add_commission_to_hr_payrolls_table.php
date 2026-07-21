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
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_payrolls', 'commission')) {

                $table->decimal('commission', 10, 2)->default(0)->after('bonuses');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {
            //
            });
}
    }
};
