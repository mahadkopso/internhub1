<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('student_id_number')->unique();
            $table->string('university')->default('University');
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->string('program')->nullable();
            $table->unsignedTinyInteger('year_of_study')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->text('bio')->nullable();
            $table->string('skills')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->foreignId('assigned_coordinator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
