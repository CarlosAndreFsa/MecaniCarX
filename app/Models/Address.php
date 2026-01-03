<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'comlement',
        'district',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
