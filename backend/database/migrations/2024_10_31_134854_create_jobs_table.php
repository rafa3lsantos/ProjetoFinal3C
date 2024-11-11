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
            $table->string('state_jobs');
            $table->string('city_jobs');
            $table->enum('status_jobs', ['in_progress', 'under_review', 'finshed']);
            $table->text('description_jobs');
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
