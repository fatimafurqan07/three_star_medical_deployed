<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hr_loan_payments')) {
    Schema::table('hr_loan_payments', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_loan_payments', 'source')) {

                $table->string('source')->default('manual')->after('type');

            } // manual, payroll_auto

            if (!Schema::hasColumn('hr_loan_payments', 'payroll_id')) {

                $table->unsignedBigInteger('payroll_id')->nullable()->after('source');

            }

            if (!Schema::hasColumn('hr_loan_payments', 'reference')) {

                $table->string('reference')->nullable()->after('payroll_id');

            } // Bank ref, voucher, etc.
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('hr_loan_payments')) {
    Schema::table('hr_loan_payments', function (Blueprint $table) {
            $table->dropColumn(['source', 'payroll_id', 'reference']);
            });
}
    }
};
