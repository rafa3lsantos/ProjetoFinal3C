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
            $table->string('name_company');
            $table->string('cnpj_company');
            $table->string('email_company');
            $table->string('phone_company')->nullable();
            $table->string('password_company');
            $table->string('photo_company')->nullable();
            $table->string('company_sector')->nullable();
            $table->string('about_company')->nullable();
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
