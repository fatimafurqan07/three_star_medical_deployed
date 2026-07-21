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
        if (Schema::hasTable('hr_attendances')) {
    Schema::table('hr_attendances', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_attendances', 'is_early_in')) {

                $table->boolean('is_early_in')->default(false)->after('late_minutes');

            }

            if (!Schema::hasColumn('hr_attendances', 'early_in_minutes')) {

                $table->integer('early_in_minutes')->default(0)->after('is_early_in');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_attendances')) {
    Schema::table('hr_attendances', function (Blueprint $table) {
            $table->dropColumn(['is_early_in', 'early_in_minutes']);
            });
}
    }
};
