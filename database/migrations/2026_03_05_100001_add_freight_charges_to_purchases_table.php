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
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {

            if (!Schema::hasColumn('purchases', 'freight_charges')) {

                $table->decimal('freight_charges', 15, 2)->default(0)->after('extra_cost');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases')) {
    Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('freight_charges');
            });
}
    }
};
