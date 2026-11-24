<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountReceivable extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'service_order_id',
        'description',
        'issue_date',
        'total',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(ReceivableInstallment::class)->orderBy('number');
    }

    public function refreshStatus(): void
    {
        $totalPaid = (float) $this->installments()->sum('received_amount');

        $status = 'pending';
        if ((float) $this->total <= $totalPaid) {
            $status = 'paid';
        } elseif ($totalPaid > 0) {
            $status = 'partially_paid';
        }

        $this->update(['status' => $status]);
    }
}
