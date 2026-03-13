<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'number',
        'title',
        'technical_description',
        'customer_description',
        'labor_cost',
        'parts_cost',
        'total',
        'status',
        'entry_date',
        'delivery_date',
    ];

    protected static function booted()
    {
        static::creating(function ($serviceOrder) {
            $serviceOrder->company_id = auth()->user()->company_id;
        });
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
        
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


}
