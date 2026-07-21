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

            if (!Schema::hasColumn('delivery_note_items', 'uom_id')) {

                $table->unsignedBigInteger('uom_id')->nullable()->after('product_id');

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
            $table->dropColumn('uom_id');
            });
}
    }
};
