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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // Foreign key to doctors
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null'); // Foreign key to patients (nullable)
            $table->date('appointment_date');
            $table->time('appointment_time'); 
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending'); // Appointment status
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid'); // Payment status
            $table->timestamps(); // Created_at and updated_at timestamps
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
