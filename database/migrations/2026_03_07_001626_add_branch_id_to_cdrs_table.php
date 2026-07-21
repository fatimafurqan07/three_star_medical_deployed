<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cdrs')) {
    Schema::table('cdrs', function (Blueprint $table) {
            if (!Schema::hasColumn('cdrs', 'branch_id')) {

                if (!Schema::hasColumn('cdrs', 'branch_id')) {

                    $table->unsignedBigInteger('branch_id')->nullable()->default(1)->after('id');

                }
            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('cdrs')) {
    Schema::table('cdrs', function (Blueprint $table) {
            if (Schema::hasColumn('cdrs', 'branch_id')) {
                $table->dropColumn('branch_id');
            }
            });
}
    }
};
