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
        if (Schema::hasTable('vendor_ledgers')) {
    Schema::table('vendor_ledgers', function (Blueprint $table) {

            if (!Schema::hasColumn('vendor_ledgers', 'debit')) {

                $table->decimal('debit', 15, 2)->default(0)->after('vendor_id');

            }

            if (!Schema::hasColumn('vendor_ledgers', 'credit')) {

                $table->decimal('credit', 15, 2)->default(0)->after('debit');

            }

            if (!Schema::hasColumn('vendor_ledgers', 'description')) {

                $table->string('description')->nullable()->after('credit');

            }
            
            // Link to source transaction (Purchase, VoucherMaster, etc.)
            $table->nullableMorphs('source'); 
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('vendor_ledgers')) {
    Schema::table('vendor_ledgers', function (Blueprint $table) {
            $table->dropColumn(['debit', 'credit', 'description']);
            $table->dropMorphs('source');
            });
}
    }
};
