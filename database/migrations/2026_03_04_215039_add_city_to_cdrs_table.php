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
        if (Schema::hasTable('cdrs')) {
    Schema::table('cdrs', function (Blueprint $table) {

            if (!Schema::hasColumn('cdrs', 'city')) {

                $table->string('city')->nullable()->after('code');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cdrs')) {
    Schema::table('cdrs', function (Blueprint $table) {
            $table->dropColumn('city');
            });
}
    }
};
