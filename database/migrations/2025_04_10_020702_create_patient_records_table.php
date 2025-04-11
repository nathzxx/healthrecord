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
        Schema::create('patient_records', function (Blueprint $table) {
            //patient information
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->date('birthday');
            $table->string('gender');
            $table->string('contactnumber');
            $table->string('emergency_contact');

            //vital sign
            $table->string('temperature')->nullable();
            $table->string('pulse')->nullable();
            $table->string('respiration_rate')->nullable();
            $table->string('blood_pressure')->nullable();
          
            //system assessment
            $table->text('general_appearance')->nullable();
            $table->text('head_eyes_ears_nose_throat')->nullable();
            $table->text('respiratory')->nullable();
            $table->text('cardiovascular')->nullable();
            $table->text('abdomen')->nullable();
            $table->text('musculoskeletal')->nullable();
            $table->text('neurological')->nullable();
            
            // Nursing Notes
            $table->text('observations')->nullable();
            $table->text('recommendations')->nullable();

              // Auto-filled fields
            $table->string('nurse_name');
            $table->date('date');

            $table->text('cdss_recommendations')->nullable();
            $table->string('cdss_risk_level')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_records');
    }
};
