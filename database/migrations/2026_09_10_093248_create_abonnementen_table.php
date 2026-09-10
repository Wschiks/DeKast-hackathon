<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonnementen', function (Blueprint $table) {
            $table->id();
            $table->string('type_naam'); // '1x per week', '2x per week', 'onbeperkt'
            $table->unsignedInteger('max_bezoeken_per_week')->nullable(); // null = onbeperkt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abonnementen');
    }
};
