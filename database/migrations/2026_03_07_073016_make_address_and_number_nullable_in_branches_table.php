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
        if (Schema::hasTable('branches')) {
    Schema::table('branches', function (Blueprint $table) {

            if (!Schema::hasColumn('branches', 'address')) {

                $table->string('address')->nullable()->change();

            }

            if (!Schema::hasColumn('branches', 'number')) {

                $table->string('number')->nullable()->change();

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('branches')) {
    Schema::table('branches', function (Blueprint $table) {

            if (!Schema::hasColumn('branches', 'address')) {

                $table->string('address')->nullable(false)->change();

            }

            if (!Schema::hasColumn('branches', 'number')) {

                $table->string('number')->nullable(false)->change();

            }
            });
}
    }
};
