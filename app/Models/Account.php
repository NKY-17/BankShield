<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'customer_id',
        'account_number',
        'account_type',
        'balance',
        'status',
        'opened_at',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function fixedDeposits(): HasMany
    {
        return $this->hasMany(FixedDeposit::class);
    }

    public function fraudLogs(): HasMany
    {
        return $this->hasMany(FraudLog::class);
    }
}
