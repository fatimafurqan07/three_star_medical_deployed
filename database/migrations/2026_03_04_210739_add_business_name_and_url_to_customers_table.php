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
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'business_name')) {

                if (!Schema::hasColumn('customers', 'business_name')) {

                    $table->string('business_name')->after('title')->nullable();

                }
            }
            if (!Schema::hasColumn('customers', 'url')) {

                if (!Schema::hasColumn('customers', 'url')) {

                    $table->string('url')->after('business_name')->nullable();

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
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['business_name', 'url']);
            });
}
    }
};
