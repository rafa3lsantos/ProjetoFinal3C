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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name_candidate');
            $table->string('email')->unique();
            $table->string('new_email')->nullable();
            $table->string('password');
            $table->string('new_password')->nullable();
            $table->string('about_candidate')->nullable();
            $table->string('cpf')->unique();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['masculino', 'feminino', 'nao-binario', 'outro'])->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('photo')->nullable();

            $table->string('phone')->nullable();
            $table->string('cep')->nullable();
            $table->string('address')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('city')->nullable();


            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->boolean('is_currently_working')->nullable();
            $table->date('start_date_work')->nullable();
            $table->date('end_date_work')->nullable();
            $table->string('description_ativities')->nullable();


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
        Schema::dropIfExists('candidates');
    }
};
