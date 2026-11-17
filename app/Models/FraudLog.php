<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FraudLog extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'reason',
        'status',
        'verification_token_hash',
        'verification_expires_at',
        'verified_at',
    ];

    protected $casts = [
        'verification_expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function fraudCase(): HasOne
    {
        return $this->hasOne(FraudCase::class);
    }
}