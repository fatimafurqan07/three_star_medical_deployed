<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('branches')) {
    Schema::table('branches', function (Blueprint $table) {
            // Remove the unique constraint so multiple users can belong to one branch
            $table->dropUnique(['user_id']);
            // Make user_id nullable (branch may not have a dedicated manager user)

            if (!Schema::hasColumn('branches', 'user_id')) {

                $table->unsignedBigInteger('user_id')->nullable()->change();

            }
            // Add is_active flag

            if (!Schema::hasColumn('branches', 'is_active')) {

                $table->boolean('is_active')->default(true)->after('number');

            }
            // Add branch code for prefix in invoice numbers

            if (!Schema::hasColumn('branches', 'branch_code')) {

                $table->string('branch_code', 10)->nullable()->after('name');

            }
            });
}
    }

    public function down(): void
    {
        if (Schema::hasTable('branches')) {
    Schema::table('branches', function (Blueprint $table) {
            $table->unique('user_id');
            $table->dropColumn(['is_active', 'branch_code']);
            });
}
    }
};
