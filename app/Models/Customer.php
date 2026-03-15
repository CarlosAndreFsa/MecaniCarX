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
}
