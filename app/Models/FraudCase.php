<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FraudCase extends Model
{
    protected $fillable = [
        'fraud_log_id',
        'stage',
        'investigation_notes',
        'assigned_to',
    ];

    public function fraudLog(): BelongsTo
    {
        return $this->belongsTo(FraudLog::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
