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

            if (!Schema::hasColumn('hr_employees', 'casual_leaves_allocated')) {

                $table->integer('casual_leaves_allocated')->default(0)->after('is_docs_submitted');

            }

            if (!Schema::hasColumn('hr_employees', 'sick_leaves_allocated')) {

                $table->integer('sick_leaves_allocated')->default(0)->after('casual_leaves_allocated');

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
            $table->dropColumn(['casual_leaves_allocated', 'sick_leaves_allocated']);
            });
}
    }
};
