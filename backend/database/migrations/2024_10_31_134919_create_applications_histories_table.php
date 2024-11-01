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
        Schema::create('applications_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'finished']);
            $table->date('status_date');
            $table->foreignId('application_id')->constrained('applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications_histories');
    }
};
