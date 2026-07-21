<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {

            if (!Schema::hasColumn('sale_items', 'delivered_qty')) {

                $table->decimal('delivered_qty', 12, 3)->default(0)->after('qty');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('sale_items')) {
    Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn('delivered_qty');
            });
}
    }
};
