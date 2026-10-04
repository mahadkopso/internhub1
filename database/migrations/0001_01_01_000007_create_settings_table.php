<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Sensible defaults for system configuration (Admin > Configure system settings)
        Schema::table('settings', function () {
            \Illuminate\Support\Facades\DB::table('settings')->insert([
                ['key' => 'app_name', 'value' => 'InternHub', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'university_name', 'value' => 'Sample University', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'application_deadline_reminder_days', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'require_coordinator_internship_approval', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'require_coordinator_application_approval', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'max_report_file_size_mb', 'value' => '10', 'created_at' => now(), 'updated_at' => now()],
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
