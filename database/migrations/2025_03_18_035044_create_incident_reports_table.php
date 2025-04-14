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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name_involve');
            $table->string('contact');
            $table->string('Incident');
            $table->time('Time');
            $table->date('Date');
            $table->string('IncidentLocation');
            $table->string('IncidentType');
            $table->time('IncidentTime');
            $table->date('IncidentDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
