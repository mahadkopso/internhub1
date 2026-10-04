<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location')->nullable();
            $table->enum('work_mode', ['onsite', 'remote', 'hybrid'])->default('onsite');
            $table->string('duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('application_deadline')->nullable();
            $table->unsignedInteger('slots_available')->default(1);
            $table->boolean('is_paid')->default(false);
            $table->decimal('stipend', 10, 2)->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('coordinator_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
