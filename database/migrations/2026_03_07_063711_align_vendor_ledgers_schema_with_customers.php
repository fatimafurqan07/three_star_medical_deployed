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

            if (!Schema::hasColumn('vendor_ledgers', 'opening_balance')) {

                $table->decimal('opening_balance', 15, 2)->default(0)->nullable()->change();

            }

            if (!Schema::hasColumn('vendor_ledgers', 'previous_balance')) {

                $table->decimal('previous_balance', 15, 2)->default(0)->change();

            }

            if (!Schema::hasColumn('vendor_ledgers', 'closing_balance')) {

                $table->decimal('closing_balance', 15, 2)->default(0)->change();

            }
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

            if (!Schema::hasColumn('vendor_ledgers', 'opening_balance')) {

                $table->text('opening_balance')->nullable(false)->change();

            }

            if (!Schema::hasColumn('vendor_ledgers', 'previous_balance')) {

                $table->text('previous_balance')->nullable(false)->change();

            }

            if (!Schema::hasColumn('vendor_ledgers', 'closing_balance')) {

                $table->text('closing_balance')->nullable(false)->change();

            }
            });
}
    }
};
