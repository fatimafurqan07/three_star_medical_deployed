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
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {

            if (!Schema::hasColumn('customers', 'gst_no')) {

                $table->string('gst_no')->after('ntn_no')->nullable();

            }

            if (!Schema::hasColumn('customers', 'drap_no')) {

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
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['gst_no', 'drap_no']);
            });
}
    }
};
