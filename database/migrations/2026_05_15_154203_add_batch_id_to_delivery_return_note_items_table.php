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
        if (Schema::hasTable('delivery_return_note_items')) {
    Schema::table('delivery_return_note_items', function (Blueprint $table) {

            if (!Schema::hasColumn('delivery_return_note_items', 'batch_id')) {

                $table->unsignedBigInteger('batch_id')->nullable()->after('product_id');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('delivery_return_note_items')) {
    Schema::table('delivery_return_note_items', function (Blueprint $table) {
            $table->dropColumn('batch_id');
            });
}
    }
};
