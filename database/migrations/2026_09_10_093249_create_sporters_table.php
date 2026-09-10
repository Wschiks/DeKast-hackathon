<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sporters', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('email')->unique();
            $table->string('barcode')->unique();
            $table->foreignId('abonnement_id')
                ->constrained('abonnementen')
                ->restrictOnDelete();
            $table->boolean('geannuleerd')->default(false);
            $table->dateTime('annuleringsdatum')->nullable();
            $table->dateTime('einddatum_toegang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sporters');
    }
};
