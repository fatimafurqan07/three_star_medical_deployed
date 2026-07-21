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
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {

            if (!Schema::hasColumn('purchases', 'po_ref')) {

                $table->string('po_ref')->nullable()->after('invoice_no');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('po_ref');
            });
}
    }
};
