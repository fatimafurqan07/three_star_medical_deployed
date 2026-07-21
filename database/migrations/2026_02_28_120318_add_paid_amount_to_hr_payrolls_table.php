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

            if (!Schema::hasColumn('hr_payrolls', 'paid_amount')) {

                $table->decimal('paid_amount', 12, 2)->nullable()->after('net_salary');

            }

            if (!Schema::hasColumn('hr_payrolls', 'payment_method')) {

                $table->string('payment_method')->nullable()->after('paid_amount');

            }

            if (!Schema::hasColumn('hr_payrolls', 'payment_notes')) {

                $table->text('payment_notes')->nullable()->after('payment_method');

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
            //
            });
}
    }
};
