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
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            // Parent/Guardian Information
            $table->string('parent_name');
            $table->string('parent_email');
            $table->string('parent_phone');
            $table->text('parent_address');
            // Student Information
            $table->string('student_name');
            $table->date('student_dob');
            $table->string('student_gender');
            $table->string('current_grade');
            $table->string('applying_grade');
            // Additional Information
            $table->text('previous_school')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('additional_notes')->nullable();
            // Status
            $table->string('status')->default('pending'); // pending, reviewed, accepted, rejected
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_applications');
    }
};
