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
        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {

            if (!Schema::hasColumn('vendors', 'gst_no')) {

                $table->string('gst_no')->after('ntn_no')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'dsl_no')) {

                $table->string('dsl_no')->after('gst_no')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'drap_no')) {

                $table->string('drap_no')->after('dsl_no')->nullable();

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['gst_no', 'dsl_no', 'drap_no']);
            });
}
    }
};
