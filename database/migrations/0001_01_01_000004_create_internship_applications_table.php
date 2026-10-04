<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();

            // Employer-side decision
            $table->enum('employer_status', ['pending', 'shortlisted', 'accepted', 'rejected'])->default('pending');
            $table->text('employer_feedback')->nullable();

            // Coordinator-side approval workflow (differentiator vs Handshake)
            $table->enum('coordinator_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('coordinator_remarks')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            // Overall computed status for student view
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'withdrawn', 'completed'])->default('pending');

            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();

            $table->unique(['internship_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
