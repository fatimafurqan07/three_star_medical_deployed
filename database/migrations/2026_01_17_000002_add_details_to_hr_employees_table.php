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
        if (Schema::hasTable('hr_employees')) {
    Schema::table('hr_employees', function (Blueprint $table) {
            //
 if (!Schema::hasColumn('hr_employees', 'address')) {
     $table->text('address')->nullable()->after('phone');
 } // Already exists, skip to avoid duplicate error
            //
 if (!Schema::hasColumn('hr_employees', 'is_docs_submitted')) {
     $table->boolean('is_docs_submitted')->default(false)->after('status');
 } // Already exists, skip to avoid duplicate error

            if (!Schema::hasColumn('hr_employees', 'document_degree')) {

                $table->string('document_degree')->nullable()->after('is_docs_submitted');

            }

            if (!Schema::hasColumn('hr_employees', 'document_certificate')) {

                $table->string('document_certificate')->nullable()->after('document_degree');

            }

            if (!Schema::hasColumn('hr_employees', 'document_hsc_marksheet')) {

                $table->string('document_hsc_marksheet')->nullable()->after('document_certificate');

            } // Intermediate

            if (!Schema::hasColumn('hr_employees', 'document_ssc_marksheet')) {

                $table->string('document_ssc_marksheet')->nullable()->after('document_hsc_marksheet');

            } // 10th

            if (!Schema::hasColumn('hr_employees', 'document_cv')) {

                $table->string('document_cv')->nullable()->after('document_ssc_marksheet');

            }
            });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hr_employees')) {
    Schema::table('hr_employees', function (Blueprint $table) {
            // $table->dropColumn('address'); // Do not drop, since we did not add in this migration
            // $table->dropColumn('is_docs_submitted'); // Do not drop, since we did not add in this migration
            $table->dropColumn([
                'document_degree',
                'document_certificate',
                'document_hsc_marksheet',
                'document_ssc_marksheet',
                'document_cv',
            ]);
            });
}
    }
};
