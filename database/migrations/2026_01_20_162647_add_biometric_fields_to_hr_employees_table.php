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
            $table->foreignId('biometric_device_id')->nullable()->after('face_photo')->constrained('biometric_devices')->onDelete('set null');

            if (!Schema::hasColumn('hr_employees', 'device_user_id')) {

                $table->string('device_user_id')->nullable()->after('biometric_device_id');

            } // Employee ID on the device

            if (!Schema::hasColumn('hr_employees', 'fingerprint_enrolled_at')) {

                $table->timestamp('fingerprint_enrolled_at')->nullable()->after('device_user_id');

            }

            if (!Schema::hasColumn('hr_employees', 'last_device_sync_at')) {

                $table->timestamp('last_device_sync_at')->nullable()->after('fingerprint_enrolled_at');

            }
            
            $table->index('device_user_id');
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
            $table->dropForeign(['biometric_device_id']);
            $table->dropColumn(['biometric_device_id', 'device_user_id', 'fingerprint_enrolled_at', 'last_device_sync_at']);
            });
}
    }
};
