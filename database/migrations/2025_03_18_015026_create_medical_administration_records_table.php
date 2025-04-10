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
        Schema::create('medical_administration_records', function (Blueprint $table) {
            $table->id();
            $table->string('PatientName');
            $table->string('Doctor/Nurse');
            $table->string(column: 'MedicationGiven');
            $table->time('Time');
            $table->date('Date');
            $table->string(column: 'SideEffect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_administration_records');
    }
};
