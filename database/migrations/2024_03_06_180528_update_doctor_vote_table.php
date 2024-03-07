<?php

use App\Models\Admin\Doctor;
use App\Models\Guest\Vote;
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
        Schema::table('doctor_vote', function (Blueprint $table) {
             // Rimuovi la chiave esterna user_id
             $table->dropForeign(['doctor_id']);
             // Rimuovi la chiave esterna role_id
             $table->dropForeign(['vote_id']);
             $table->dropPrimary(['doctor_id', 'vote_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_vote', function (Blueprint $table) {
            $table->primary(['doctor_id', 'vote_id']);
        });
    }
};
