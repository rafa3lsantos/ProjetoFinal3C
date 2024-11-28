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
        Schema::create('professional_experiences', function (Blueprint $table) {
            $table->id();

            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->boolean('is_currently_working')->nullable();
            $table->date('start_date_work')->nullable();
            $table->date('end_date_work')->nullable();
            $table->string('description_ativities')->nullable();
            $table->foreignId('candidate_id')->constrained('candidates');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_experiences');
    }
};
