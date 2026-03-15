<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            ->id();
            // Chaves estrangeiras
            ->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            ->foreignId('brand_id')->constrained('brands')->restrictOnDelete();
            
            // Dados do veículo
            ->string('model'); // Ex: Gol, Palio, Civic
            ->string('plate')->unique(); // Placa
            ->year('year')->nullable(); // Ano
            ->string('color')->nullable(); // Cor
            ->string('vin')->nullable(); // Chassi (Opcional, mas útil para peças)
            
            ->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}