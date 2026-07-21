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
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {
            // Payroll type differentiation

            if (!Schema::hasColumn('hr_payrolls', 'payroll_type')) {

                $table->enum('payroll_type', ['monthly', 'daily'])->default('monthly')->after('employee_id');

            }
            
            // Enhanced salary breakdown

            if (!Schema::hasColumn('hr_payrolls', 'gross_salary')) {

                $table->decimal('gross_salary', 10, 2)->default(0)->after('basic_salary');

            }

            if (!Schema::hasColumn('hr_payrolls', 'allowances')) {

                $table->decimal('allowances', 10, 2)->default(0)->after('gross_salary');

            }

            if (!Schema::hasColumn('hr_payrolls', 'attendance_deductions')) {

                $table->decimal('attendance_deductions', 10, 2)->default(0)->after('allowances');

            }

            if (!Schema::hasColumn('hr_payrolls', 'manual_deductions')) {

                $table->decimal('manual_deductions', 10, 2)->default(0)->after('attendance_deductions');

            }

            if (!Schema::hasColumn('hr_payrolls', 'manual_allowances')) {

                $table->decimal('manual_allowances', 10, 2)->default(0)->after('manual_deductions');

            }

            if (!Schema::hasColumn('hr_payrolls', 'carried_forward_deduction')) {

                $table->decimal('carried_forward_deduction', 10, 2)->default(0)->after('manual_allowances');

            }
            
            // Admin notes and tracking

            if (!Schema::hasColumn('hr_payrolls', 'notes')) {

                $table->text('notes')->nullable()->after('net_salary');

            }

            if (!Schema::hasColumn('hr_payrolls', 'auto_generated')) {

                $table->boolean('auto_generated')->default(false)->after('notes');

            }
            
            // Enhanced status workflow
            $table->dropColumn('status');
            });
}
        
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_payrolls', 'status')) {

                $table->enum('status', ['generated', 'reviewed', 'paid'])->default('generated')->after('auto_generated');

            }
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete()->after('status');

            if (!Schema::hasColumn('hr_payrolls', 'reviewed_at')) {

                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {
            $table->dropColumn([
                'payroll_type',
                'gross_salary',
                'allowances',
                'attendance_deductions',
                'manual_deductions',
                'manual_allowances',
                'carried_forward_deduction',
                'notes',
                'auto_generated',
                'reviewed_by',
                'reviewed_at',
            ]);
            
            $table->dropColumn('status');
            });
}
        
        if (Schema::hasTable('hr_payrolls')) {
    Schema::table('hr_payrolls', function (Blueprint $table) {

            if (!Schema::hasColumn('hr_payrolls', 'status')) {

                $table->enum('status', ['pending', 'paid'])->default('pending');

            }
            });
}
    }
};
