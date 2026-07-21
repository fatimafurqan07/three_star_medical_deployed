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

            if (!Schema::hasColumn('customer_ledgers', 'debit')) {

                $table->decimal('debit', 15, 2)->default(0)->after('customer_id');

            }

            if (!Schema::hasColumn('customer_ledgers', 'credit')) {

                $table->decimal('credit', 15, 2)->default(0)->after('debit');

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
            $table->dropColumn(['debit', 'credit']);
            });
}
    }
};
