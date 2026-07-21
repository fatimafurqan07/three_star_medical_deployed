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

            if (!Schema::hasColumn('customers', 'bank_name')) {

                $table->string('bank_name')->nullable()->after('payment_mode');

            }

            if (!Schema::hasColumn('customers', 'cheque_no')) {

                $table->string('cheque_no')->nullable()->after('bank_name');

            }

            if (!Schema::hasColumn('customers', 'cheque_date')) {

                $table->date('cheque_date')->nullable()->after('cheque_no');

            }
            });
}

        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {

            if (!Schema::hasColumn('vendors', 'bank_name')) {

                $table->string('bank_name')->nullable()->after('payment_mode');

            }

            if (!Schema::hasColumn('vendors', 'cheque_no')) {

                $table->string('cheque_no')->nullable()->after('bank_name');

            }

            if (!Schema::hasColumn('vendors', 'cheque_date')) {

                $table->date('cheque_date')->nullable()->after('cheque_no');

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
            $table->dropColumn(['bank_name', 'cheque_no', 'cheque_date']);
            });
}

        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'cheque_no', 'cheque_date']);
            });
}
    }
};
