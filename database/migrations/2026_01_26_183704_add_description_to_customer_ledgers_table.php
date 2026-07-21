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
        if (Schema::hasTable('customer_ledgers')) {
    Schema::table('customer_ledgers', function (Blueprint $table) {

            if (!Schema::hasColumn('customer_ledgers', 'description')) {

                $table->text('description')->nullable()->after('opening_balance');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('customer_ledgers')) {
    Schema::table('customer_ledgers', function (Blueprint $table) {
            $table->dropColumn('description');
            });
}
    }
};
