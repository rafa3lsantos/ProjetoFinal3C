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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            $table->enum('formation', ['graduação', 'pos-graduação', 'mestrado', 'doutorado'])->nullable();
            $table->string('institution')->nullable();
            $table->string('experience')->nullable();
            $table->enum('degree', ['tecnologo', 'licenciatura', 'bacharelado'])->nullable();
            $table->enum('status', ['completo', 'em andamento', 'incompleto'])->nullable();
            $table->string('course')->nullable();
            $table->date('start_date_course')->nullable();
            $table->date('end_date_course')->nullable();
            $table->enum('certificate_type', ['conquista', 'certificado'])->nullable();
            $table->string('certificate_title')->nullable();
            $table->string('certificate_description')->nullable();
            $table->string('certificate_institution')->nullable();
            $table->foreignId('candidate_id')->constrained('candidates');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
