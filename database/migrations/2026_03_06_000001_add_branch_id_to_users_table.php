<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
    Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'branch_id')) {

                $table->unsignedBigInteger('branch_id')->nullable()->after('usertype');

            }
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
}

        // Mark super admin user (email=admin@admin.com) as super_admin
        \DB::table('users')->where('email', 'admin@admin.com')->update(['usertype' => 'super_admin']);
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
    Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
            });
}
    }
};
