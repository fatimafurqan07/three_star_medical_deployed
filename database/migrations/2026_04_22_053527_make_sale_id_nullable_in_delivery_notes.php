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
        if (Schema::hasTable('delivery_notes')) {
    Schema::table('delivery_notes', function (Blueprint $table) {

            if (!Schema::hasColumn('delivery_notes', 'sale_id')) {

                $table->unsignedBigInteger('sale_id')->nullable()->change();

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('delivery_notes')) {
    Schema::table('delivery_notes', function (Blueprint $table) {

            if (!Schema::hasColumn('delivery_notes', 'sale_id')) {

                $table->unsignedBigInteger('sale_id')->nullable(false)->change();

            }
            });
}
    }
};
