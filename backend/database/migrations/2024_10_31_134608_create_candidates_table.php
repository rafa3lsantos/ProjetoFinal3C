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
            $table->unsignedBigInteger('curriculum_id')->nullable(); // Chave estrangeira para o curriculum
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
            $table->string('curriculum')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('curriculum_id')
                ->references('id')->on('curriculum')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['curriculum_id']);

            $table->dropColumn('curriculum_id');
        });
    }
};
