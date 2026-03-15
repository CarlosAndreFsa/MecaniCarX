<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
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

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    
    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }
    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->company_id = auth()->user()->company_id;
        });
    }
}
