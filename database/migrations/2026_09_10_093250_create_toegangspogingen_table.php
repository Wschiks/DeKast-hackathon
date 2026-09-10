<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toegangspogingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sporter_id')
                ->constrained('sporters')
                ->cascadeOnDelete();
            $table->dateTime('tijdstip')->useCurrent();
            $table->boolean('toegestaan');
            $table->string('foutmelding')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toegangspogingen');
    }
};
