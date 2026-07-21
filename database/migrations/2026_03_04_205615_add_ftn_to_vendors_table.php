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

            if (!Schema::hasColumn('vendors', 'ftn_no')) {

                $table->string('ftn_no')->after('drap_no')->nullable();

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
            $table->dropColumn('ftn_no');
            });
}
    }
};
