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

            if (!Schema::hasColumn('customer_ledgers', 'source_type')) {

                $table->string('source_type')->nullable()->after('description');

            }

            if (!Schema::hasColumn('customer_ledgers', 'source_id')) {

                $table->unsignedBigInteger('source_id')->nullable()->after('source_type');

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
            $table->dropColumn(['source_type', 'source_id']);
            });
}
    }
};
