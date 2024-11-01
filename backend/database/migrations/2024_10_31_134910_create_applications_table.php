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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->date('application_date');
            $table->unsignedBigInteger('job_id');
            $table->foreignId('job_id')->references('id')->on('jobs');  
            $table->foreignId('candidate_id')->constrained('candidates');
            $table->foreignId('job_id')->constrained('jobs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
