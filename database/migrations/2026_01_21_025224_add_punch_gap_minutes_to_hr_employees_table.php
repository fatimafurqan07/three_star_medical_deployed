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
            // Individual punch gap setting per employee (null = use global default)
            $table->unsignedInteger('punch_gap_minutes')->nullable()->after('last_device_sync_at');
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
            $table->dropColumn('punch_gap_minutes');
            });
}
    }
};
