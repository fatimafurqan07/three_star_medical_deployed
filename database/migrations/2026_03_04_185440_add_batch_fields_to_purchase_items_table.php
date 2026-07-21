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
        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {
            if (! Schema::hasColumn('purchase_items', 'batch_no')) {

                if (!Schema::hasColumn('purchase_items', 'batch_no')) {

                    $table->string('batch_no')->nullable();

                }

                if (!Schema::hasColumn('purchase_items', 'mfg_date')) {

                    $table->date('mfg_date')->nullable();

                }

                if (!Schema::hasColumn('purchase_items', 'exp_date')) {

                    $table->date('exp_date')->nullable();

                }
            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_items', 'batch_no')) {
                $table->dropColumn(['batch_no', 'mfg_date', 'exp_date']);
            }
            });
}
    }
};
