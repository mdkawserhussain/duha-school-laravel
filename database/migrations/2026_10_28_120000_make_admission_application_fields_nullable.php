<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The public admission form collects a smaller set of fields than the
     * original schema: parent_address, student_gender and current_grade are
     * not part of the form, so they must accept NULL values.
     */
    public function up(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            $table->text('parent_address')->nullable()->change();
            $table->string('student_gender')->nullable()->change();
            $table->string('current_grade')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            $table->text('parent_address')->nullable(false)->change();
            $table->string('student_gender')->nullable(false)->change();
            $table->string('current_grade')->nullable(false)->change();
        });
    }
};
