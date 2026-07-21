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

            if (!Schema::hasColumn('customer_ledgers', 'branch_id')) {

                $table->unsignedBigInteger('branch_id')->nullable()->after('customer_id');

            }
            });
}
        if (Schema::hasTable('vendor_ledgers')) {
    Schema::table('vendor_ledgers', function (Blueprint $table) {

            if (!Schema::hasColumn('vendor_ledgers', 'branch_id')) {

                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');

            }
            });
}
        if (Schema::hasTable('customer_payments')) {
    Schema::table('customer_payments', function (Blueprint $table) {

            if (!Schema::hasColumn('customer_payments', 'branch_id')) {

                $table->unsignedBigInteger('branch_id')->nullable()->after('customer_id');

            }
            });
}
        if (Schema::hasTable('vendor_payments')) {
    Schema::table('vendor_payments', function (Blueprint $table) {

            if (!Schema::hasColumn('vendor_payments', 'branch_id')) {

                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');

            }
            });
}

        // Data migration: Populate branch_id from customers/vendors
        DB::statement('UPDATE customer_ledgers cl JOIN customers c ON cl.customer_id = c.id SET cl.branch_id = c.branch_id WHERE cl.branch_id IS NULL');
        DB::statement('UPDATE vendor_ledgers vl JOIN vendors v ON vl.vendor_id = v.id SET vl.branch_id = v.branch_id WHERE vl.branch_id IS NULL');
        DB::statement('UPDATE customer_payments cp JOIN customers c ON cp.customer_id = c.id SET cp.branch_id = c.branch_id WHERE cp.branch_id IS NULL');
        DB::statement('UPDATE vendor_payments vp JOIN vendors v ON vp.vendor_id = v.id SET vp.branch_id = v.branch_id WHERE vp.branch_id IS NULL');
    }

    public function down(): void
    {
        if (Schema::hasTable('customer_ledgers')) {
    Schema::table('customer_ledgers', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            });
}
        if (Schema::hasTable('vendor_ledgers')) {
    Schema::table('vendor_ledgers', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            });
}
        if (Schema::hasTable('customer_payments')) {
    Schema::table('customer_payments', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            });
}
        if (Schema::hasTable('vendor_payments')) {
    Schema::table('vendor_payments', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            });
}
    }
};
