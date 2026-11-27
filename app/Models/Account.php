<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\FixedDeposit;

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
}
