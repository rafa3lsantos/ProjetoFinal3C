<?php

use App\Models\Certificate;
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
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates');
            $table->string('name_candidate')->nullable();
            $table->string('email_candidate')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('cep')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('experience')->nullable();
            $table->enum('formation', ['graduação', 'pos-graduação', 'mestrado', 'doutorado'])->nullable();
            $table->string('institution')->nullable();
            $table->enum('degree', ['tecnologo', 'licenciatura', 'bacharelado'])->nullable();
            $table->enum('status', ['completo', 'em andamento', 'incompleto'])->nullable();
            $table->string('course')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('certificate_type',['conquista', 'certificado'])->nullable();
            $table->string('certificate_title')->nullable();
            $table->string('certificate_description')->nullable();
            $table->string('certificate_institution')->nullable();
            $table->string('soft_skills')->nullable();
            $table->string('hard_skills')->nullable();
            $table->string('language')->nullable();
            $table->string('language_level')->nullable();
            $table->string('curriculum_attachment')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
