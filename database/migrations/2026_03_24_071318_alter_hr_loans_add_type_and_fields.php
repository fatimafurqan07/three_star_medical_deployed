<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hr_loans')) {
    Schema::table('hr_loans', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_loans', 'loan_type')) {

                $table->enum('loan_type', ['salary_deduction', 'self_paid'])->default('salary_deduction')->after('employee_id');

            }

            if (!Schema::hasColumn('hr_loans', 'total_installments')) {

                $table->integer('total_installments')->nullable()->after('installment_amount');

            }

            if (!Schema::hasColumn('hr_loans', 'installments_paid')) {

                $table->integer('installments_paid')->default(0)->after('total_installments');

            }

            if (!Schema::hasColumn('hr_loans', 'start_month')) {

                $table->string('start_month', 7)->nullable()->after('installments_paid');

            } // YYYY-MM

            if (!Schema::hasColumn('hr_loans', 'expected_end_month')) {

                $table->string('expected_end_month', 7)->nullable()->after('start_month');

            } // YYYY-MM

            if (!Schema::hasColumn('hr_loans', 'disbursed_at')) {

                $table->date('disbursed_at')->nullable()->after('expected_end_month');

            }

            if (!Schema::hasColumn('hr_loans', 'approved_at')) {

                $table->date('approved_at')->nullable()->after('disbursed_at');

            }

            if (!Schema::hasColumn('hr_loans', 'approved_by')) {

                $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');

            }

            if (!Schema::hasColumn('hr_loans', 'notes')) {

                $table->text('notes')->nullable()->after('reason');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('hr_loans')) {
    Schema::table('hr_loans', function (Blueprint $table) {
            $table->dropColumn([
                'loan_type', 'total_installments', 'installments_paid',
                'start_month', 'expected_end_month', 'disbursed_at',
                'approved_at', 'approved_by', 'notes',
            ]);
            });
}
    }
};
