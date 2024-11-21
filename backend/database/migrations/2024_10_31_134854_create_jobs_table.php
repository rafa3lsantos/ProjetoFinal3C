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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('work_model', ['presential', 'remote', 'hybrid']);
            $table->enum('job_type', ['effective', 'freelancer', 'temporary', 'internship']);
            $table->string('jobs_state');
            $table->string('jobs_city');
            $table->enum('jobs_status', ['in_progress', 'under_review', 'finished']);
            $table->text('jobs_description');
            $table->foreignId('recruiter_id')->constrained('recruiters');
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
