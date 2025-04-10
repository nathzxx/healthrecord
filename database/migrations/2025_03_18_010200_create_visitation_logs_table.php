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
        Schema::create('visitation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('Reason');
            $table->time('Time');
            $table->string('Date');
            $table->string('InterventionProvided');
            $table->string('FollowUps');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitation_logs');
    }
};
