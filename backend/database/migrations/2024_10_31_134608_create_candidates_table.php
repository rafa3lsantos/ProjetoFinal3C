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
                $table->id('id_candidate'); 
                $table->string('name');
                $table->string('cpf');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phone');
                $table->enum('gender', ['masculino', 'feminino', 'nao-binario', 'outro']);
                $table->string('cep');
                $table->text('address');
                $table->string('state');
                $table->string('city');
                $table->string('language');
                $table->text('curriculum');

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
