<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            // Chaves estrangeiras
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->restrictOnDelete();
            
            // Dados do veículo
            $table->string('model'); // Ex: Gol, Palio, Civic
            $table->string('plate')->unique(); // Placa
            $table->year('year')->nullable(); // Ano
            $table->string('color')->nullable(); // Cor
            $table->string('vin')->nullable(); // Chassi (Opcional, mas útil para peças)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
