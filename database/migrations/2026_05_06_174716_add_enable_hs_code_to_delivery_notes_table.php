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
        if (Schema::hasTable('delivery_notes')) {
    Schema::table('delivery_notes', function (Blueprint $table) {

            if (!Schema::hasColumn('delivery_notes', 'enable_hs_code')) {

                $table->boolean('enable_hs_code')->default(true)->after('note');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('delivery_notes')) {
    Schema::table('delivery_notes', function (Blueprint $table) {
            $table->dropColumn('enable_hs_code');
            });
}
    }
};
