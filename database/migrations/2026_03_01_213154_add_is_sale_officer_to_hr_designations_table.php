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
        if (Schema::hasTable('hr_designations')) {
    Schema::table('hr_designations', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_designations', 'is_sale_officer')) {

                $table->boolean('is_sale_officer')->default(false)->after('name');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_designations')) {
    Schema::table('hr_designations', function (Blueprint $table) {
            $table->dropColumn('is_sale_officer');
            });
}
    }
};
