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
        Schema::create('doctor_sponsorship', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsorship_id')->constrained()->cascadeOnDelete();
            $table->primary(['doctor_id', 'sponsorship_id']);
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_sponsorship');
    }
};
