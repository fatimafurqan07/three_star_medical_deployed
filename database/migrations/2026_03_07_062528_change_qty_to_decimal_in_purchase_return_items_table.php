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
        if (Schema::hasTable('purchase_return_items')) {
    Schema::table('purchase_return_items', function (Blueprint $table) {

            if (!Schema::hasColumn('purchase_return_items', 'qty')) {

                $table->decimal('qty', 12, 3)->change();

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchase_return_items')) {
    Schema::table('purchase_return_items', function (Blueprint $table) {

            if (!Schema::hasColumn('purchase_return_items', 'qty')) {

                $table->integer('qty')->change();

            }
            });
}
    }
};
