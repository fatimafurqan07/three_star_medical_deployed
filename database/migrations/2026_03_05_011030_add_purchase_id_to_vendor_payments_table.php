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
        if (Schema::hasTable('vendor_payments')) {
    Schema::table('vendor_payments', function (Blueprint $table) {

            if (!Schema::hasColumn('vendor_payments', 'purchase_id')) {

                $table->unsignedBigInteger('purchase_id')->nullable()->after('vendor_id');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('vendor_payments')) {
    Schema::table('vendor_payments', function (Blueprint $table) {
            $table->dropColumn('purchase_id');
            });
}
    }
};
