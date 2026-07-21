<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {

            if (!Schema::hasColumn('customers', 'sales_officer_id')) {

                $table->unsignedBigInteger('sales_officer_id')->nullable()->after('customer_type');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('sales_officer_id');
            });
}
    }
};
