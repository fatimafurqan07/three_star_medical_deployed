<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {

            if (!Schema::hasColumn('customers', 'shipping_address')) {

                $table->string('shipping_address')->nullable();

            }

            if (!Schema::hasColumn('customers', 'shipping_city')) {

                $table->string('shipping_city')->nullable();

            }

            if (!Schema::hasColumn('customers', 'shipping_country')) {

                $table->string('shipping_country')->nullable();

            }

            if (!Schema::hasColumn('customers', 'shipping_phone')) {

                $table->string('shipping_phone')->nullable();

            }

            if (!Schema::hasColumn('customers', 'shipping_fax')) {

                $table->string('shipping_fax')->nullable();

            }

            if (!Schema::hasColumn('customers', 'shipping_email')) {

                $table->string('shipping_email')->nullable();

            }
            });
}

        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {

            if (!Schema::hasColumn('vendors', 'shipping_address')) {

                $table->string('shipping_address')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'shipping_city')) {

                $table->string('shipping_city')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'shipping_country')) {

                $table->string('shipping_country')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'shipping_phone')) {

                $table->string('shipping_phone')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'shipping_fax')) {

                $table->string('shipping_fax')->nullable();

            }

            if (!Schema::hasColumn('vendors', 'shipping_email')) {

                $table->string('shipping_email')->nullable();

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('customers')) {
    Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['shipping_address', 'shipping_city', 'shipping_country', 'shipping_phone', 'shipping_fax', 'shipping_email']);
            });
}

        if (Schema::hasTable('vendors')) {
    Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['shipping_address', 'shipping_city', 'shipping_country', 'shipping_phone', 'shipping_fax', 'shipping_email']);
            });
}
    }
};
