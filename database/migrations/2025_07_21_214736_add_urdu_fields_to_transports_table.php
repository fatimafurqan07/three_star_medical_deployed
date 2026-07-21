<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('transports')) {
    Schema::table('transports', function (Blueprint $table) {

            if (!Schema::hasColumn('transports', 'name_ur')) {

                $table->string('name_ur')->nullable()->after('name');

            }

            if (!Schema::hasColumn('transports', 'address_ur')) {

                $table->text('address_ur')->nullable()->after('address');

            }
            });
}
    }

    public function down()
    {
        if (Schema::hasTable('transports')) {
    Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn(['name_ur', 'address_ur']);
            });
}
    }
};
