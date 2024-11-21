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
        Schema::create('recruiters', function (Blueprint $table) {
            $table->id();
            $table->string('recruiter_name');
            $table->string('recruiter_cpf');
            $table->enum('recruiter_gender', ['male', 'female'. 'non-binary', 'other', 'prefer not to say']);
            $table->string('recruiter_phone')->nullable();
            $table->date('recruiter_birthdate')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('recruiter_photo')->nullable();
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiters');
    }
};
