<?php

namespace App\Models;

use Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'brand_id',
        'model',
        'plate',
        'year',
        'color',
        'vin',
    ];

    protected static function booted()
    {
        static::creating(function ($vehicle) {
            $vehicle->company_id = auth()->user()->company_id;
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Relacionamento: Veículo pertence a um Cliente
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Relacionamento: Veículo pertence a uma Marca
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Relacionamento: Veículo tem muitas Ordens de Serviço
    public function serviceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }
}