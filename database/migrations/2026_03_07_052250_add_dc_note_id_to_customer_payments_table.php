<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('customer_payments')) {
    Schema::table('customer_payments', function (Blueprint $table) {

            if (!Schema::hasColumn('customer_payments', 'dc_note_id')) {

                $table->unsignedBigInteger('dc_note_id')->nullable()->after('sale_id');

            }

            if (!Schema::hasColumn('customer_payments', 'account_id')) {

                $table->unsignedBigInteger('account_id')->nullable()->after('payment_date');

            }

            if (!Schema::hasColumn('customer_payments', 'description')) {

                $table->string('description')->nullable()->after('account_id');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('customer_payments')) {
    Schema::table('customer_payments', function (Blueprint $table) {
            $table->dropColumn(['dc_note_id', 'account_id', 'description']);
            });
}
    }
};
