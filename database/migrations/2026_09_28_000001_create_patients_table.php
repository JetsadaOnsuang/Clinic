<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('id_card', 13)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone', 15);
            $table->text('address')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->text('allergies')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
