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
            $table->string('name');
            $table->string('about')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('cpf')->unique();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique()->nullable(); // Campo opcional
            $table->enum('gender', ['masculino', 'feminino', 'nao-binario', 'outro'])->nullable(); // Campo opcional
            $table->string('cep')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable(); // Campo opcional
            $table->text('curriculum')->nullable(); // Campo opcional
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
