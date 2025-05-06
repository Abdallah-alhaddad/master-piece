<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('symptom_specialization', function (Blueprint $table) {
            $table->id();
            $table->string('symptom');
            $table->string('specialization');
            $table->integer('weight')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('symptom_specialization');
    }
}; 