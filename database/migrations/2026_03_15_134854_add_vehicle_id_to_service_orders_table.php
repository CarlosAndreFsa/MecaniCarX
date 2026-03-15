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
        Schema::table('service_orders', function (Blueprint $table) {
            // Adiciona a coluna vehicle_id depois da coluna customer_id
            // É importante ser `nullable()` porque já existem OSs no banco sem veículo.
            // `nullOnDelete()` fará com que, se um veículo for deletado, o histórico da OS permaneça, apenas com o vehicle_id nulo.
            $table->foreignId('vehicle_id')->nullable()->after('customer_id')->constrained('vehicles')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropColumn('vehicle_id');
        });
    }
};
