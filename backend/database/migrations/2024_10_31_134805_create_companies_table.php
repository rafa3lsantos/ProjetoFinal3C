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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_cnpj');
            $table->string('company_phone')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('company_photo')->nullable();
            $table->string('company_sector')->nullable();
            $table->string('about_company')->nullable();
            $table->foreignId('recruiter_id');
            $table->foreign('recruiter_id')->references('id')->on('recruiters'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
