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

            if (!Schema::hasColumn('purchase_items', 'qty')) {

                $table->decimal('qty', 12, 3)->default(0)->change();

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('purchase_items')) {
    Schema::table('purchase_items', function (Blueprint $table) {

            if (!Schema::hasColumn('purchase_items', 'qty')) {

                $table->integer('qty')->default(0)->change();

            }
            });
}
    }
};
