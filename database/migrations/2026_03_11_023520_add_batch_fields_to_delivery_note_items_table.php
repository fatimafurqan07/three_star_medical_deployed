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
        if (Schema::hasTable('delivery_note_items')) {
    Schema::table('delivery_note_items', function (Blueprint $table) {

            if (!Schema::hasColumn('delivery_note_items', 'batch_id')) {

                $table->unsignedBigInteger('batch_id')->nullable()->after('product_id');

            }

            if (!Schema::hasColumn('delivery_note_items', 'lot_number')) {

                $table->string('lot_number')->nullable()->after('batch_id');

            }

            if (!Schema::hasColumn('delivery_note_items', 'mfg_date')) {

                $table->date('mfg_date')->nullable()->after('lot_number');

            }

            if (!Schema::hasColumn('delivery_note_items', 'exp_date')) {

                $table->date('exp_date')->nullable()->after('mfg_date');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('delivery_note_items')) {
    Schema::table('delivery_note_items', function (Blueprint $table) {
            $table->dropColumn(['batch_id', 'lot_number', 'mfg_date', 'exp_date']);
            });
}
    }
};
