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
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {

            if (!Schema::hasColumn('sales', 'credit_days')) {

                $table->integer('credit_days')->nullable()->after('sale_status');

            }

            if (!Schema::hasColumn('sales', 'due_date')) {

                $table->date('due_date')->nullable()->index()->after('credit_days');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['credit_days', 'due_date']);
            });
}
    }
};
