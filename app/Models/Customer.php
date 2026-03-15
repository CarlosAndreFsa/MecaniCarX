<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 
        'name', 
        'name_fantasy', 
        'email', 
        'cpf_cnpj',         
        'phone', 
        'active', 
        'website',
    ];

    public function address(): MorphOne
    {
       return $this->morphOne(Address::class, 'addressable');

    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
    
    public function serviceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted()
    {
        static::creating(function ($customer) {
            if (auth()->check()) {
                $customer->company_id = auth()->user()->company_id;
            }
        });
    }
}
