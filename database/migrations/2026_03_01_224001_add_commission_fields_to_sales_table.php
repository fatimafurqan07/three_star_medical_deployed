<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            // Total commission the employee is entitled to for this sale

            if (!Schema::hasColumn('sales', 'total_commission')) {

                $table->decimal('total_commission', 10, 2)->default(0)->after('invoice_no');

            }
            // Commission already paid out in payroll (cumulative)

            if (!Schema::hasColumn('sales', 'commission_paid')) {

                $table->decimal('commission_paid', 10, 2)->default(0)->after('total_commission');

            }
            // Commission share ratio (default 50% = 0.5), configurable per sale

            if (!Schema::hasColumn('sales', 'commission_share_ratio')) {

                $table->decimal('commission_share_ratio', 5, 2)->default(0.50)->after('commission_paid');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('sales')) {
    Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['total_commission', 'commission_paid', 'commission_share_ratio']);
            });
}
    }
};
