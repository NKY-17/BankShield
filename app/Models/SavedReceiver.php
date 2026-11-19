<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedReceiver extends Model
{
    protected $fillable = [
        'user_id',
        'receiver_name',
        'bank_name',
        'account_number',
        'nickname',
    ];

    protected function casts(): array
    {
        return [
            'account_number' => 'encrypted',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
