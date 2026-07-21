<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sale_item_batches')) {
    Schema::table('sale_item_batches', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_item_batches', 'sale_item_id')) {

                $table->unsignedBigInteger('sale_item_id')->nullable()->change();

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('sale_item_batches')) {
    Schema::table('sale_item_batches', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_item_batches', 'sale_item_id')) {

                $table->unsignedBigInteger('sale_item_id')->nullable(false)->change();

            }
            });
}
    }
};
