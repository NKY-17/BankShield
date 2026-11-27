<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedDeposit extends Model
{
    protected $fillable = [
        'customer_id',
        'account_id',
        'deposit_number',
        'principal_amount',
        'interest_rate',
        'duration_months',
        'start_date',
        'maturity_date',
        'expected_interest',
        'maturity_amount',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'principal_amount' => 'decimal:2',
            'interest_rate' => 'decimal:2',
            'duration_months' => 'integer',
            'start_date' => 'date',
            'maturity_date' => 'date',
            'expected_interest' => 'decimal:2',
            'maturity_amount' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
